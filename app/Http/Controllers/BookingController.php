<?php

namespace App\Http\Controllers;

use App\BookingNutrition;
use App\BookingRooms;
use App\Client;
use App\Rooms;
use App\RoomTypes;
use App\Tariff;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $roomTypes = RoomTypes::get();
        $json = [];
        foreach ($roomTypes as $roomType) {
            $json[$roomType->name]['rooms'] = collect($roomType->rooms)->toArray();
            foreach ($roomType->rooms as $room) {
                $json[$roomType->name]['rooms']['bookings'] = collect($room->bookings)->toArray();
                foreach ($room->bookings as $booking) {
                    $json[$roomType->name][$booking->id]['room']['client'] = collect($booking->client)->toArray();
                    $json[$roomType->name][$booking->id]['room']['tariff'] = collect($booking->tariff)->toArray();
                    $json[$roomType->name][$booking->id]['room']['tariff']['treatments'] = collect($booking->tariff->treatments)->toArray();
                    $json[$roomType->name][$booking->id]['room']['tariff']['eatings'] = collect($booking->tariff->eatings)->toArray();
                    $json[$roomType->name][$booking->id]['room']['tariff']['services'] = collect($booking->tariff->services)->toArray();
                }
            }
        }

        dd($json);
        return view('management-system.booking.index', ['roomTypes' => $roomTypes, 'json' => collect($json)->toJson()]);
    }

    /**
     * @return View
     */
    public function storeView(): View
    {
        $rooms = Rooms::get();
        $tariff = Tariff::get();
        $clients = Client::get();

        return view('management-system.booking.store', ['rooms' => $rooms, 'tariff' => $tariff, 'clients' => $clients]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function booking(Request $request): RedirectResponse
    {
        BookingController::validateRequest($request);

        if (BookingRooms::isContainsPeriod($request->room,
            $request->date_start . ' ' . $request->time_start,
            $request->date_end . ' ' . $request->time_end
        )) {
            Session::flash('room', 'Номер занят');

            return Redirect::back()->withInput();
        } else {
            DB::transaction(function () use ($request) {
                if ($request->client_type == 'newClient') {
                    $client = Client::saveClient($request);
                } else {
                    $client = Client::where('number', '=', $request->oldClient)->first();
                    $client->increment('number_of_sessions');
                }
                $id = BookingRooms::bookingRoom($request, $client->id);
                BookingNutrition::createNutritionInfo($request, $id);
            });
        }

        Session::flash('success', 'Успешно забронировано');
        return Redirect::refresh();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changeDepartureTime(Request $request): JsonResponse
    {
        $booking = BookingRooms::findOrFail($request->id);

        $booking->price = BookingRooms::recalculatePrice($request, $booking);
        $booking->date_start = $request->date;
        $booking->time_start = $request->time;

        if ($booking->save()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changeCheckInTime(Request $request): JsonResponse
    {
        $booking = BookingRooms::findOrFail($request->id);

        if ($booking->populated) {
            return response()->json([
                'success' => false,
                'message' => 'Нельзя изменить время заселения, клиент уже в заселился'
            ]);
        } else {
            $booking->price = BookingRooms::recalculatePrice($request, $booking);
            $booking->date_start = $request->date;
            $booking->time_start = $request->time;

            if ($booking->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Время заселения изменено (был произведён перерасчёт суммы)'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'что-то пошло не так'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkRoomBooking(Request $request): JsonResponse
    {
        if (BookingRooms::isContainsPeriod(
            $request->room,
            $request->start,
            $request->end
        )) {
            return response()->json([
                'error' => true,
                'message' => 'Номер занят'
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Номер свободен'
        ]);
    }

    /**
     * @param BookingRooms $booking
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroyBooking(BookingRooms $booking): RedirectResponse
    {
        $booking->delete();

        return Redirect::route('booking.board');
    }

    /**
     * @param BookingRooms $booking
     * @return View
     */
    public function editBookingView(BookingRooms $booking): View
    {
        $tariff = Tariff::get();
        $rooms = Rooms::get();
        $clients = Client::get();

        return view('management-system.booking.edit', [
            'booking' => $booking,
            'tariff' => $tariff,
            'rooms' => $rooms,
            'clients' => $clients,
        ]);
    }

    /**
     * @param BookingRooms $booking
     * @return View
     */
    public function editNutritionBooking(BookingRooms $booking): View
    {
        $from = Carbon::parse($booking->date_start . ' ' . $booking->time_start);
        $to = Carbon::parse($booking->date_end . ' ' . $booking->time_end);
        $days = $to->diffInDays($from) + 1;

        return view('management-system.booking.edit-nutrition', ['booking' => $booking, 'days' => $days]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function editBooking(Request $request): RedirectResponse
    {
        $contains = BookingRooms::isContainsPeriod(
            $request->room,
            $request->date_start . ' ' . $request->time_start,
            $request->date_end . ' ' . $request->time_end,
            $request->bookingId
        );

        if ($contains) {
            Session::flash('room', 'Номер занят');

            return Redirect::back()->withInput();
        }

        BookingRooms::where('id', '=', $request->bookingId)->update([
            'date_start' => $request->date_start,
            'time_start' => $request->time_start,
            'date_end' => $request->date_end,
            'time_end' => $request->time_end,
            'old' => $request->old,
            'new' => $request->new,
            'price' => $request->price,
            'discount' => $request->discount,
            'booking_type' => $request->booking_type,
            'payment_type' => $request->payment_type,
            'payment_state' => $request->payment_state,
            'type_of_day' => $request->type_of_day,
            'room_id' => $request->room,
            'tariff_id' => $request->tariff,
        ]);

        Session::flash('success', 'Информация о бронировании изменена');
        return Redirect::route('booking');
    }

    /**
     * @param $request
     * @return void
     */
    public static function validateRequest($request)
    {
        $messages = [
            'date_start.required' => 'Дата заселения обязательна',
            'date_start.after_or_equal' => 'Нельзя бронировать на такое число',
            'time_start.required' => 'Время заселегия обязательно',
            'date_end.required' => 'Дата выселения обязательна',
            'date_end.after_or_equal' => 'Дата выселения не может быть раньше даты заселения',
            'time_end.required' => 'Время выселения обязательно',
            'old.required' => 'Вы забыли заполнить количество взрослых людей',
            'price.required' => 'Цена обязательна',
            'name.required' => 'Имя клиента обязательно',
            'number.required' => 'Номер телефона клиента обязателен',
            'number.unique' => 'Клиент с таким телефоном уже зарегистрирован',
            'mail.required' => 'Почтовый адрес клиента обязателен',
            'serial.required' => 'Серия паспорта обязательна',
            'passport_number.required' => 'Номер паспорта обязателен',
            'passport_data.required' => 'Дата выдачи паспорта обязательна',
            'oldClient.required' => 'Это поле обязательно',
            'tariff.required' => 'Выберите тариф',
            'room.required' => 'Выбирете комнату',
        ];

        if ($request->client_type == 'newClient') {
            $request->validate([
                'date_start' => 'required|after_or_equal:now',
                'time_start' => 'required',
                'date_end' => 'required|date|after_or_equal:date_start',
                'time_end' => 'required',
                'old' => 'required',
                'price' => 'required',
                'name' => 'required',
                'number' => 'required|unique:clients',
                'mail' => 'required',
                'passport_data' => 'required',
                'passport_number' => 'required',
                'serial' => 'required',
                'room' => 'required',
                'tariff' => 'required',
            ], $messages);
        } else {
            $request->validate([
                'date_start' => 'required|after_or_equal:now',
                'time_start' => 'required',
                'date_end' => 'required|date|after_or_equal:date_start',
                'time_end' => 'required',
                'old' => 'required',
                'price' => 'required',
                'oldClient' => 'required',
            ], $messages);
        }
    }

}

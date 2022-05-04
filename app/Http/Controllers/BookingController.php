<?php

namespace App\Http\Controllers;

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
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $roomTypes = RoomTypes::get();

        return view('management-system.booking.index', ['roomTypes' => $roomTypes]);
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
     * @throws ValidationException
     */
    public function booking(Request $request): RedirectResponse
    {
        self::validateRequest($request);

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
                BookingRooms::bookingRoom($request, $client->id);
            });
        }

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
    public function editBooking(BookingRooms $booking): View
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

<?php

namespace App\Http\Controllers;

use App\BookingRooms;
use App\Client;
use App\Rooms;
use App\Tariff;
use Carbon\CarbonPeriod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * @return View
     */
    public function storeView(): View
    {
        $rooms = Rooms::get();
        $tariff = Tariff::get();
        $clients = Client::get();

        return view('booking.store', ['rooms' => $rooms, 'tariff' => $tariff, 'clients' => $clients]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function booking(Request $request): RedirectResponse
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
            'phone.required' => 'Номер телефона клиента обязателен',
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
                'phone' => 'required',
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

        if (BookingRooms::isContainsPeriod(
            $request->room,
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

        dd('Бронь прошла, информация о ней сохранилась в таблицы(booking_rooms, clients)');
        return Redirect::refresh();
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
}

<?php

namespace App\Http\Controllers;

use App\Rooms;
use App\RoomTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editRoom(Request $request): JsonResponse
    {
        if (strlen($request->option) > 0) {
            Rooms::where('id', $request->id)->update([
                $request->name => $request->option,
            ]);
            return response()->json([]);
        }
        return response()->json([], 400);
    }

    /**
     * @return View
     */
    public function createRoomView(): View
    {
        $types = RoomTypes::get();

        return view('rooms.create', ['types' => $types]);
    }

    /**
     * @return View
     */
    public function RoomView(): View
    {
        $rooms = Rooms::get();

        return view('rooms.index', ['rooms' => $rooms]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function storeRoom(Request $request): View
    {
        $messages = [
            'number.required' => 'Вы забыли заполнить номер номера',
            'number.unique' => 'Такой номер уже есть',
            'price.required' => 'Вы забыли заполнить цену за сутки проживания',
            'space.required' => 'Вы забыли заполнить количество спальных мест',
        ];

        $request->validate([
            'number' => 'required|unique:rooms',
            'price' => 'required',
            'space' => 'required',
        ], $messages);

        $room = new Rooms($request->all());
        $room->save();

        return $this->createRoomView();
    }

    /**
     * @param $id
     * @return View
     */
    public function destroyRoom($id): View
    {
        Rooms::destroy($id);

        return $this->RoomView();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getRoomPrice(Request $request): JsonResponse
    {
        return response()->json(
            ['room' => Rooms::where('id', '=', $request->id)->get()]
        );
    }
}

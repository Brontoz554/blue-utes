<?php

namespace App\Http\Controllers;

use App\DomainMonitoring;
use App\Rooms;
use App\RoomTypes;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RoomsController extends Controller
{
    /**
     * @return View
     */
    public function createTypeView(): View
    {
        $types = RoomTypes::all();

        return view('rooms.create-type', ['types' => $types]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function storeType(Request $request): View
    {
        $messages = [
            'name.required' => 'Название типа обязательно',
            'name.unique' => 'Такое название типа уже есть'
        ];

        $request->validate([
            'name' => 'required|unique:room_types',
        ], $messages);

        $type = new RoomTypes($request->all());
        $type->save();

        return $this->createTypeView();
    }

    /**
     * @param $id
     * @return View
     */
    public function destroyType($id): View
    {
        RoomTypes::destroy($id);

        return $this->createTypeView();
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editType(Request $request): JsonResponse
    {
        if (strlen($request->option) > 0) {
            RoomTypes::where('id', $request->id)->update([
                $request->name => $request->option,
            ]);
            return response()->json([]);
        }
        return response()->json([], 400);
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

        return view('rooms.create-room', ['types' => $types]);
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
            'price.required' => 'Вы забыли заполнить цену за сутки проживания',
            'space.required' => 'Вы забыли заполнить количество спальных мест',
        ];

        $request->validate([
            'number' => 'required',
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
}

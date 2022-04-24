<?php

namespace App\Http\Controllers;

use App\RoomTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TypeRoomsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['manager']);
    }

    /**
     * @return View
     */
    public function createTypeView(): View
    {
        $types = RoomTypes::all();

        return view('rooms.type.create', ['types' => $types]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeType(Request $request): RedirectResponse
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

        return Redirect::route('room.type.view');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroyType($id): RedirectResponse
    {
        RoomTypes::destroy($id);

        return Redirect::route('room.type.view');
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
}

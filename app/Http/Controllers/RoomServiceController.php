<?php

namespace App\Http\Controllers;

use App\RoomService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class RoomServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @return View
     */
    public function roomServiceView(): View
    {
        $types = RoomService::all();

        return view('management-system.room-service.create', ['types' => $types]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeRoomService(Request $request): RedirectResponse
    {
        $messages = [
            'name.required' => 'Название услуги обязательно',
            'name.unique' => 'Такая услуга уже есть'
        ];

        $request->validate([
            'name' => 'required|unique:room_services',
        ], $messages);

        $type = new RoomService($request->all());
        $type->save();

        return Redirect::route('room.service.view');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroyRoomService($id): RedirectResponse
    {
        RoomService::destroy($id);

        return Redirect::route('room.service.view');
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editRoomService(Request $request): JsonResponse
    {
        if (strlen($request->option) > 0) {
            RoomService::where('id', $request->id)->update([
                $request->name => $request->option,
            ]);
            return response()->json([]);
        }
        return response()->json([], 400);
    }
}

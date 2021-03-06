<?php

namespace App\Http\Controllers;

use App\Rooms;
use App\RoomService;
use App\RoomServiceRoom;
use App\RoomTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RoomsController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware(['admin']);
//    }

    /**
     * @return View
     */
    public function RoomView(): View
    {
        $rooms = Rooms::get();
        $services = RoomService::get();

        return view('management-system.rooms.index', ['rooms' => $rooms, 'services' => $services]);
    }

    /**
     * @return View
     */
    public function createRoomView(): View
    {
        $types = RoomTypes::get();
        $services = RoomService::get();

        return view('management-system.rooms.create', ['types' => $types, 'services' => $services]);
    }

    /**
     * @param Request $request
     * @return View
     * @throws ValidationException
     */
    public function storeRoom(Request $request): View
    {
        RoomsController::validateRequest($request);

        DB::transaction(function () use ($request) {
            $room = new Rooms([
                'room_types_id' => $request->input('room_types_id'),
                'number' => $request->input('number'),
                'space' => $request->input('space'),
                'another' => $request->input('another'),
                'multiple' => filter_var($request->input('multiple'), FILTER_VALIDATE_BOOLEAN),
            ]);
            $room->save();

            if ($request->input('another') == 'on') {
                $ids = $request->input('servicesId');
                $services = RoomService::find(explode(',', $ids));
                $room->roomServices()->attach($services);
            }
        });

        return $this->createRoomView();
    }

    /**
     * @param $id
     * @return View
     */
    public function destroyRoom($id): View
    {
        RoomServiceRoom::where('room_id', '=', $id)->delete();
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
            ['room' => Rooms::where('id', '=', $request->id)->first()]
        );
    }

    public function editRoomView($id)
    {
        $room = Rooms::find($id);
        $types = RoomTypes::get();
        $services = RoomService::get();

        return view('management-system.rooms.edit', ['room' => $room, 'types' => $types, 'services' => $services]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function editRoom(Request $request): RedirectResponse
    {
        RoomsController::validateRequest($request, $request->input('dataId'));

        Rooms::where('id', '=', $request->input('dataId'))->update([
            'room_types_id' => $request->input('room_types_id'),
            'number' => $request->input('number'),
            'space' => $request->input('space'),
            'description' => $request->input('description'),
            'another' => $request->input('another'),
            'multiple' => filter_var($request->input('multiple'), FILTER_VALIDATE_BOOLEAN)
        ]);

        if ($request->input('another') == 'on') {
            $room = Rooms::where('id', '=', $request->input('dataId'))->first();
            $services = RoomService::find(explode(',', $request->input('servicesId')));
            RoomServiceRoom::where('room_id', '=', $request->input('dataId'))->delete();
            $room->roomServices()->attach($services);
        }

        return Redirect::route('room.view');
    }

    /**
     * @param Rooms $room
     * @return void
     */
    public function repairRoom(Rooms $room)
    {

    }

    /**
     * @param Request $request
     * @param $id
     * @return void
     */
    public static function validateRequest(Request $request, $id = false)
    {
        if ($id) {
            $uniqueRule = Rule::unique('rooms')->ignore($id);
        } else {
            $uniqueRule = 'unique:rooms';
        }
        $messages = [
            'number.required' => '???? ???????????? ?????????????????? ?????????? ????????????',
            'number.unique' => '?????????? ?????????? ?????? ????????',
            'space.required' => '???? ???????????? ?????????????????? ???????????????????? ???????????????? ????????',
        ];

        $request->validate([
            'number' => "required|$uniqueRule",
            'space' => 'required',
        ], $messages);
    }

    /**
     * @param Rooms $room
     * @return JsonResponse
     */
    public function getAllRoomBookings(Rooms $room): JsonResponse
    {
        $response = [];

        foreach ($room->bookings as $booking) {
            $response[$booking->id]['room'] = collect($booking->room)->toArray();
            $response[$booking->id]['booking'] = collect($booking)->toArray();
            $response[$booking->id]['tariff'] = collect($booking->tariff)->toArray();
            $response[$booking->id]['client'] = collect($booking->client)->toArray();
            $response[$booking->id]['nutritious'] = collect($booking->nutritious)->toArray();
        }

        return response()->json([
            'data' => $response,
        ], 200);
    }
}

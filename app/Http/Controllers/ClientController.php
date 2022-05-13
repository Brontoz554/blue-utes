<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware(['admin']);
//    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editClient(Request $request): JsonResponse
    {
        if (strlen($request->option) > 0) {
            Client::where('id', $request->id)->update([
                $request->name => $request->option,
            ]);
            return response()->json([]);
        }
        return response()->json([], 400);
    }

    /**
     * @return View
     */
    public function clients(): View
    {
        $clients = Client::get();

        return view('management-system.clients.index', ['clients' => $clients]);
    }

}

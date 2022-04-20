<?php

namespace App\Http\Controllers;

use App\Rooms;
use App\Tariff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TariffController extends Controller
{
    /**
     * @return View
     */
    public function createView(): View
    {
        return view('tariff.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $tariff = new Tariff(Tariff::prepareObject($request));
        $tariff->save();

        return Redirect::refresh();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $tariff = Tariff::get();

        return view('tariff.index', ['tariff' => $tariff]);
    }

    /**
     * @param $id
     * @return View
     */
    public function destroyTariff($id): View
    {
        Tariff::destroy($id);

        return $this->index();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editTariff(Request $request): JsonResponse
    {
        if (strlen($request->option) > 0) {
            Tariff::where('id', $request->id)->update([
                $request->name => $request->option,
            ]);
            return response()->json([]);
        }
        return response()->json([], 400);
    }
}

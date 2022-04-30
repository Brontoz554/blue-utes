<?php

namespace App\Http\Controllers;

use App\Eating;
use App\Services;
use App\Tariff;
use App\Treatment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TariffController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @return View
     */
    public function createView(): View
    {
        $treatments = Treatment::get();
        $eat = Eating::get();
        $services = Services::get();

        return view('management-system.tariff.create', ['treatments' => $treatments, 'eat' => $eat, 'services' => $services]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'name.required' => 'Название тарифа обязательно',
            'price.required' => 'Цена тарифа обязательна',
            'check_out_start.required' => 'Время заселения обязательно',
            'check_out_end.required' => 'Время выселения обязательно',
        ];

        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ], $messages);

        DB::transaction(function () use ($request) {
            $tariff = new Tariff([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'treatment' => $request->input('treatment'),
                'nutrition' => $request->input('nutrition'),
                'another' => $request->input('another'),
            ]);
            $tariff->save();

            if ($request->input('treatment') == 'on') {
                $ids = $request->input('treatmentsId');
                $treatments = Treatment::find(explode(',', $ids));
                $tariff->treatments()->attach($treatments);
            }

            if ($request->input('nutrition') == 'on') {
                $ids = $request->input('eatingId');
                $eating = Eating::find(explode(',', $ids));
                $tariff->eatings()->attach($eating);
            }

            if ($request->input('another') == 'on') {
                $ids = $request->input('servicesId');
                $services = Services::find(explode(',', $ids));
                $tariff->services()->attach($services);
            }
        });

        return Redirect::refresh();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $tariff = Tariff::get();

        return view('management-system.tariff.index', ['tariff' => $tariff]);
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getTariffPrice(Request $request): JsonResponse
    {
        return response()->json(
            ['tariff' => Tariff::where('id', '=', $request->id)->get()]
        );
    }
}

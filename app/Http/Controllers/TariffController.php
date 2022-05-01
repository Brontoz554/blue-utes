<?php

namespace App\Http\Controllers;

use App\Eating;
use App\EatingTariff;
use App\Services;
use App\ServiceTariff;
use App\Tariff;
use App\Treatment;
use App\TreatmentTariff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
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

        return view('management-system.tariff.create', [
            'treatments' => $treatments,
            'eat' => $eat, 'services' => $services
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        TariffController::validateTariff($request);

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
     * @param Tariff $tariff
     * @return View
     */
    public function editTariffView(Tariff $tariff): View
    {
        $treatments = Treatment::get();
        $eat = Eating::get();
        $services = Services::get();

        return view('management-system.tariff.edit', [
            'tariff' => $tariff,
            'treatments' => $treatments,
            'eat' => $eat,
            'services' => $services
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function editTariff(Request $request): RedirectResponse
    {
        TariffController::validateTariff($request, $request->input('id'));

        DB::transaction(function () use ($request) {
            Tariff::where('id', '=', $request->input('id'))->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'treatment' => isset($request->treatment) ? 'on' : 'off',
                'nutrition' => isset($request->nutrition) ? 'on' : 'off',
                'another' => isset($request->another) ? 'on' : 'off',
            ]);

            if ($request->input('treatment') == 'on') {
                $ids = $request->input('treatmentsId');
                $treatments = Treatment::find(explode(',', $ids));

                TreatmentTariff::where('tariff_id', '=', $request->input('id'))->delete();
                $tariff = Tariff::where('id', '=', $request->input('id'))->first();
                $tariff->treatments()->attach($treatments);
            }

            if ($request->input('nutrition') == 'on') {
                $ids = $request->input('eatingId');
                $nutritious = Eating::find(explode(',', $ids));

                EatingTariff::where('tariff_id', '=', $request->input('id'))->delete();
                $tariff = Tariff::where('id', '=', $request->input('id'))->first();
                $tariff->eatings()->attach($nutritious);
            }

            if ($request->input('another') == 'on') {
                $ids = $request->input('servicesId');
                $nutritious = Services::find(explode(',', $ids));

                ServiceTariff::where('tariff_id', '=', $request->input('id'))->delete();
                $tariff = Tariff::where('id', '=', $request->input('id'))->first();
                $tariff->services()->attach($nutritious);
            }
        });

        return Redirect::route('tariff');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getTariffInfo(Request $request): JsonResponse
    {
        return response()->json(
            ['tariff' => Tariff::where('id', '=', $request->id)->get()]
        );
    }

    public static function validateTariff(Request $request, $id = false)
    {
        if ($id) {
            $uniqueRule = Rule::unique('tariffs')->ignore($id);
        } else {
            $uniqueRule = 'unique:tariffs';
        }

        $messages = [
            'name.required' => 'Название тарифа обязательно',
            'name.unique' => 'Такое название тарифа уже занято',
            'price.required' => 'Цена тарифа обязательна',
            'check_out_start.required' => 'Время заселения обязательно',
            'check_out_end.required' => 'Время выселения обязательно',
        ];

        $request->validate([
            'name' => "required|$uniqueRule",
            'price' => 'required',
        ], $messages);
    }
}

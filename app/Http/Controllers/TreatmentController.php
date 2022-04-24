<?php

namespace App\Http\Controllers;

use App\Treatment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TreatmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @return View
     */
    public function treatmentView(): View
    {
        $types = Treatment::all();

        return view('treatment.create', ['types' => $types]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeTreatment(Request $request): RedirectResponse
    {
        $messages = [
            'name.required' => 'Название лечебной услуги обязательно',
            'name.unique' => 'Такая услуга уже есть'
        ];

        $request->validate([
            'name' => 'required|unique:treatments',
        ], $messages);

        $type = new Treatment($request->all());
        $type->save();

        return Redirect::route('treatment.view');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroyTreatment($id): RedirectResponse
    {
        Treatment::destroy($id);

        return Redirect::route('treatment.view');
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editTreatment(Request $request): JsonResponse
    {
        if (strlen($request->option) > 0) {
            Treatment::where('id', $request->id)->update([
                $request->name => $request->option,
            ]);
            return response()->json([]);
        }
        return response()->json([], 400);
    }
}

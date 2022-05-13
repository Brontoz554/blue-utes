<?php

namespace App\Http\Controllers;

use App\Eating;
use App\Treatment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EatingController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware(['admin']);
//    }

    /**
     * @return View
     */
    public function eatingView(): View
    {
        $types = Eating::all();

        return view('management-system.eating.create', ['types' => $types]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeEating(Request $request): RedirectResponse
    {
        $messages = [
            'name.required' => 'Название услуги обязательно',
            'name.unique' => 'Такая услуга уже есть'
        ];

        $request->validate([
            'name' => 'required|unique:eating',
        ], $messages);

        $type = new Eating($request->all());
        $type->save();

        return Redirect::route('eating.view');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroyEating($id): RedirectResponse
    {
        Eating::destroy($id);

        return Redirect::route('eating.view');
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editEating(Request $request): JsonResponse
    {
        if (strlen($request->option) > 0) {
            Eating::where('id', $request->id)->update([
                $request->name => $request->option,
            ]);
            return response()->json([]);
        }
        return response()->json([], 400);
    }
}

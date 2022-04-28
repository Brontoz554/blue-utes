<?php

namespace App\Http\Controllers;

use App\Services;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    /**
     * @return View
     */
    public function servicesView(): View
    {
        $types = Services::all();

        return view('management-system.services.create', ['types' => $types]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeServices(Request $request): RedirectResponse
    {
        $messages = [
            'name.required' => 'Название дополнительной услуги обязательно',
            'name.unique' => 'Такая услуга уже есть'
        ];

        $request->validate([
            'name' => 'required|unique:services',
        ], $messages);

        $type = new Services($request->all());
        $type->save();

        return Redirect::route('services.view');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroyService($id): RedirectResponse
    {
        Services::destroy($id);

        return Redirect::route('services.view');
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editServices(Request $request): JsonResponse
    {
        if (strlen($request->option) > 0) {
            Services::where('id', $request->id)->update([
                $request->name => $request->option,
            ]);
            return response()->json([]);
        }
        return response()->json([], 400);
    }
}

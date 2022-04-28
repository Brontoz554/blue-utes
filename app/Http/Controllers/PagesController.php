<?php

namespace App\Http\Controllers;

use App\Pages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PagesController extends Controller
{

    /**
     * @return View
     */
    public function createView(): View
    {
        return view('management-content.pages.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'pageName' => 'required|single_word_or_website',
            'content' => 'required',
        ]);

        //генерируем новую страницу и сохраняем данные о ней
        Artisan::call('generate:route ' . $request->pageName);

        $page = new Pages();
        $page->name = $request->input('pageName');
        $page->content = $request->input('content');
        $page->type_id = '1';

        $page->save();

        return Redirect::route('pages');
    }

    /**
     * @return View
     */
    public function show(): View
    {
        $pages = Pages::all();

        return view('management-content.pages.show', ['pages' => $pages]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $page = Pages::findOrFail($id);
//        Artisan::call('remove:route ' . $page->name);
        $page->delete();
        session()->flash('message', 'Страница была удалена');

        return Redirect::back();
    }

    /**
     * @param $id
     * @return View
     */
    public function editView($id): View
    {
        $page = Pages::find($id);

        return view('management-content.pages.edit', ['page' => $page]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function edit(Request $request): RedirectResponse
    {
        $updates = [];
        foreach ($request->all() as $key => $item) {
            if ($key != '_token') {
                $updates[$key] = $item;
            }
        }

        Pages::where('id', $request->id)->update($updates);

        return Redirect::back();
    }
}

<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'manager']);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $news = News::all();

        return view('news.index', ['news' => $news]);
    }

    /**
     * @return View
     */
    public function createView(): View
    {
        return view('news.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'subject' => 'required|max:100',
            'news_content' => 'required|max:1000',
            'image' => 'required',
            'link' => 'required_without:pageName|website',
            'pageName' => 'required_without:link',
        ]);

        //генерируем новую страницу
        if ($request->checkbox === 'yes') {
            if (Artisan::call('generate:route ' . $request->pageName)) {
                $link = $request->link ?? $request->pageName;
                $imageName = md5(microtime(true)) . '.' . $request->file('image')->extension();
                $news = new News([
                    'user_id' => Auth::id(),
                    'subject' => $request->subject,
                    'content' => $request->news_content,
                    'image' => $imageName,
                    'link' => Str::snake($link),
                ]);
                if ($news->save()) {
                    $request->file('image')->move('storage/', $imageName);
                }
            }
        }

        session()->flash('message', 'Новость успешно создана');
        return Redirect::refresh();
    }

    /**
     * @return View
     */
    public function show(): View
    {
        $news = News::all();

        return view('news.show', ['news' => $news]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        News::destroy($id);
        session()->flash('message', 'Новость была удалена');

        return Redirect::back();
    }

    /**
     * @param $id
     * @return View
     */
    public function editView($id): View
    {
        $news = News::find($id);

        return view('news.edit', ['news' => $news]);
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
            if ($key == 'image') {
                $imageName = md5(microtime(true)) . '.' . $request->file('image')->extension();
                $request->file('image')->move('storage/', $imageName);
                $updates[$key] = $imageName;
            }
        }
        unset($updates['_token']);
        News::where('id', $request->id)->update($updates);

        return Redirect::back();
    }
}

<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('manager');
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
            'news_content' => 'required|max:500',
            'image' => 'required',
            'link' => 'required|website',
        ]);

        $imageName = md5(microtime(true)) . '.' . $request->file('image')->extension();
        $news = new News([
            'author_id' => Auth::id(),
            'subject' => $request->subject,
            'content' => $request->news_content,
            'image' => $imageName,
            'link' => $request->link,
        ]);
        if ($news->save()) {
            $request->file('image')->move('images', $imageName);
        }

        session()->flash('message', 'Новость успешно создана');
        return Redirect::refresh();
    }
}

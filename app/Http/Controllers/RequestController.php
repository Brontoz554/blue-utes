<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

class RequestController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function callMe(Request $request): RedirectResponse
    {
        $content = [
            'number' => $request->input('number'),
            'name' => $request->input('name'),
            'comment' => $request->input('comment'),
        ];
//        $request = new \App\Request($content);
//        $request->save();

        TelegramBotController::sendMessage($content);

        return Redirect::route('main');
    }
}

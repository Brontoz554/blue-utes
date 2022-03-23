<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;

class TelegramBotController extends Controller
{
    /**
     * @return void
     * @throws Exception
     */
    public function setWebhook()
    {
        $bot = new BotApi('5174671948:AAGbDuirO7x92Ai3W--aiYkd-WmCol1IW70');

        dd($bot->setWebhook('https://utes.0370.ru/telegramm-bot-message'));
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getMessage(Request $request)
    {
        Log::debug('tg-message', $request->all());
    }
}

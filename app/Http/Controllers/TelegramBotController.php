<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

class TelegramBotController extends Controller
{
    const TOKEN = '5174671948:AAGbDuirO7x92Ai3W--aiYkd-WmCol1IW70';

    /**
     * @return void
     * @throws Exception
     */
    public function setWebhook()
    {
        $bot = new BotApi(self::TOKEN);

        dd($bot->setWebhook('https://utes.0370.ru/telegramm-bot-message'));
    }

    /**
     * @param Request $request
     * @return void
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function getMessage(Request $request)
    {
        $bot = new BotApi(self::TOKEN);
        $bot->setCurlOption(CURLOPT_TIMEOUT, 15);
        $updates = $request->all();
        $textUpdates = $updates['message']['text'];
        $chatId = $updates['message'] ? $updates['message']['chat']['id'] : $updates['callback_query']['from']['id']; // чат от которого пришло сообщение
        Log::debug('tg-message', [$textUpdates]);
        Log::debug('chatId', [$chatId]);

        $bot->sendMessage($chatId, 'Мне пока нечего ответить на ваше сообщение..');
    }
}

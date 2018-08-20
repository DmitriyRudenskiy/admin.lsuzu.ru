<?php
namespace App\Service\Telegram;

use App\Service\Telegram;
use InvalidArgumentException;

class TaskClient extends Telegram
{
    protected function init()
    {
        if (empty(env('TELEGRAM_BOT_SPARE_PART')) || empty(env('TELEGRAM_CHAT_ID_TASK'))) {
            throw new InvalidArgumentException();
        }

        $this->bot = trim(env('TELEGRAM_BOT_SPARE_PART'));
        $this->chatId = (int)env('TELEGRAM_CHAT_ID_TASK');
    }

    public function sendSvala($text)
    {
        $this->chatId = (int)env('TELEGRAM_WORKER_V1');

        $this->send($text);

        $this->chatId = (int)env('TELEGRAM_CHAT_ID_TASK');
    }
}
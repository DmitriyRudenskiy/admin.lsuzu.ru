<?php
namespace App\Service\Telegram;

use App\Service\Telegram;
use InvalidArgumentException;

class ToptkNotificationClient extends Telegram
{
    protected function init()
    {
        if (empty(env('TELEGRAM_BOT_SPARE_PART')) || empty(env('TELEGRAM_CHAT_ID_TOPTK_NOTIFICATION'))) {
            throw new InvalidArgumentException();
        }

        $this->bot = trim(env('TELEGRAM_BOT_SPARE_PART'));
        $this->chatId = (int)env('TELEGRAM_CHAT_ID_TOPTK_NOTIFICATION');
    }
}
<?php

namespace App\Service;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;

class Telegram
{
    const URL = "https://api.telegram.org/bot%s/sendMessage?";

    /**
     * @var string
     */
    protected $bot;

    /**
     * @var int
     */
    protected $chatId;

    /**
     * @var string
     */
    protected $text;

    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        if (empty(env('TELEGRAM_BOT')) || empty(env('TELEGRAM_CHAT_ID'))) {
            throw new InvalidArgumentException();
        }

        $this->bot = trim(env('TELEGRAM_BOT'));
        $this->chatId = (int)env('TELEGRAM_CHAT_ID');
    }

    public function send($text)
    {
        if (empty($text)) {
            return false;
        }

        $this->text = $text;


        $url = $this->getUrl();

        $response = @file_get_contents($url);

        $this->sendMail($text);

        return !empty($response);
    }

    public function getUrl()
    {
        $data = [
            'chat_id' => $this->chatId,
            'text' => $this->text
        ];

        return sprintf(self::URL, $this->bot) . http_build_query($data);
    }

    protected function sendMail($text)
    {
        Mail::raw($text, function (Message $message) {
            $message->to(env('MAIL_TO'));
            $message->subject('Нужен заголовок');
        });
    }
}
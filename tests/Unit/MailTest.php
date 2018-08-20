<?php

namespace Tests\Unit;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ConsoleTest extends TestCase
{
    /**
     * Simple email sender.
     *
     * @return void
     */
    public function testSend()
    {
        $text = 'Тестовое сообщение!';

        Mail::raw($text, function (Message $message) {
            $message->to(env('MAIL_TO'));
            $message->subject('[Тест] Нужен заголовок');
        });

        var_dump(env('MAIL_TO'));

        $this->assertTrue(true);
    }
}

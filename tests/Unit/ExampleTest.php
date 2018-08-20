<?php

namespace Tests\Unit;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Simple email sender.
     *
     * @return void
     */
    public function testMail()
    {
        Mail::raw('Text to e-mail', function (Message $message) {
            $message->to(env('MAIL_TO'));
            $message->subject(date("H:i") . ' I work!');
        });

        $this->assertEquals(sizeof(Mail::failures()), 0);
    }

    /**
     * Simple test session.
     *
     * @return void
     */
    public function testSession()
    {
        $data = 'TEST_SESSION';

        $value =  session('key');

        var_dump($value);

        session(['key' => $data]);

        $value =  session('key');

        var_dump($value);
    }
}

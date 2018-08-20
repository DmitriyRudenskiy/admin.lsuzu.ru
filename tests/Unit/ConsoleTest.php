<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ConsoleTest extends TestCase
{
    /**
     * Simple email sender.
     *
     * @return void
     */
    public function testHelp()
    {
        Artisan::call('help');

        $resultAsText = Artisan::output();

        $this->assertEquals(strpos($resultAsText, 'help') , 9);
    }
}

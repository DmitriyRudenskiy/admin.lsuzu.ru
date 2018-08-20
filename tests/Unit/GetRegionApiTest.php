<?php

namespace Tests\Unit;

use App\Service\GetRegionApi;
use Tests\TestCase;

class GetRegionApiTest extends TestCase
{
    /**
     * Simple email sender.
     *
     * @return void
     */
    public function testGetRegionToNumber( )
    {
        $service = new GetRegionApi();

        $this->assertEquals($service->get("9930108735"), "Новосибирская область");
    }
}

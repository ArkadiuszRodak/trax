<?php

namespace Tests\Unit;

use Tests\TestCase;

class CarTest extends TestCase
{
    public function testUserCanSeeCars()
    {
        $this->login()->json('get', url('api/cars'))->assertOk();
    }
}

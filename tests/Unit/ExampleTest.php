<?php

namespace Tests\Unit;

use App\Util\Taobao\Client;
use App\Util\Taobao\OrderGetRequest;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        $client = new Client();
        $request = new OrderGetRequest();

        $client->exec($request,'6200404d67cace6c4959956e4f92624e569544bbdb86957714376387');

        $this->assertTrue(true);
    }
}

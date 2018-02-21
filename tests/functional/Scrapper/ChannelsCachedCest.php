<?php

namespace Scrapper;

use App\Vsetv\Scrapper\Channels;
use App\Vsetv\Scrapper\ChannelsCached;
use Carbon\Carbon;
use FunctionalTester as Tester;
use Illuminate\Support\Facades\Cache;
use \Mockery as m;

class ChannelsCachedCest
{
    private $channels;

    public function _before()
    {
        $this->channels = m::mock(Channels::class);
    }


    public function testSomething(Tester $I)
    {
        $expected = '<body><p>string</p></body>';
        $channels = m::mock(Channels::class);
        $channels->shouldReceive('__toString')->andReturn($expected);

        Cache::shouldReceive('remember')
            ->once()
            ->andReturn($channels);

        $result = (string)new ChannelsCached($channels);

        $I->assertEquals($expected, $result);
    }
}

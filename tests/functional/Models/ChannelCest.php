<?php

namespace Models;

use App\Models\Programme;
use FunctionalTester as Tester;

class ChannelCest
{
    public function testChannelHasProgramme(Tester $I)
    {
        $channel = $I->makeChannel();
        $I->makeProgramme(['channel_id' => $channel->id]);

        $I->assertEquals(1, count($channel->programmes));
        $I->assertInstanceOf(Programme::class, $channel->programmes->first());
    }
}
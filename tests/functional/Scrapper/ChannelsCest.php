<?php

namespace Scrapper;

use App\Vsetv\Scrapper\Channels;
use FunctionalTester as Tester;

use Goutte\Client;
use \Mockery as m;

class ChannelsCest
{

    public function _before()
    {
        $this->channels = m::mock(Channels::class);
    }


    public function testsScrapChannels(Tester $I)
    {
        $expected = '<body><p>string</p></body>';

        $guzzleClient = $I->mockGuzzle(200, $expected);
        $goutteClient = new Client();
        $goutteClient->setClient($guzzleClient);

        $result = new Channels($goutteClient);

        $I->assertEquals($expected, (string)$result);
    }
}

<?php

namespace Services;

use App\Services\Scrapper;
use FunctionalTester as Tester;
use \Mockery as m;
use Goutte\Client;


class ProgrammeCest
{

    public function _before()
    {
        $this->scrapper = m::mock(Scrapper::class);
    }

    public function testsScrapNoCache(Tester $I)
    {
        $expected = '<body><p>string</p></body>';

        $goutteClient = $this->mockGoutteClient($I, $expected);

        $scrapper = new Scrapper($goutteClient);

        $I->assertEquals($expected, $scrapper->do("url", false));
    }

    public function testsScrapWithCache(Tester $I)
    {
        $expected = '<body><p>string</p></body>';

        $goutteClient = $this->mockGoutteClient($I, $expected);

        $scrapper = new Scrapper($goutteClient);

        $I->assertEquals($expected, $scrapper->do("url"));
    }

    public function testsScrapAndPuttInCache(Tester $I)
    {
        $randomKey = str_random(10);
        $expected = '<body><p>string</p></body>';

        $goutteClient = $this->mockGoutteClient($I, $expected);

        $scrapper = new Scrapper($goutteClient);

        $I->assertEquals($expected, $scrapper->do($randomKey, true));
    }

    private function mockGoutteClient($I, $expected)
    {
        $guzzleClient = $I->mockGuzzle(200, $expected);
        $goutteClient = new Client();
        $goutteClient->setClient($guzzleClient);

        return $goutteClient;
    }
}

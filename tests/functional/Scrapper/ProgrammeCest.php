<?php

namespace Scrapper;

use App\Vsetv\Scrapper\Programme;
use FunctionalTester as Tester;

use Goutte\Client;
use \Mockery as m;

class ProgrammeCest
{

    public function _before()
    {
        $this->programme = m::mock(Programme::class);
    }


    public function testsScrapProgramme(Tester $I)
    {
        $expected = '<body><p>string</p></body>';

        $guzzleClient = $I->mockGuzzle(200, $expected);
        $goutteClient = new Client();
        $goutteClient->setClient($guzzleClient);

        $result = new Programme($goutteClient, "url");

        $I->assertEquals($expected, (string)$result);
    }
}

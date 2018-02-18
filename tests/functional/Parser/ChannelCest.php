<?php
namespace Parse;

use App\Vsetv\Parser\Channels;
use App\Vsetv\Parser\Time;
use FunctionalTester as Tester;
use Symfony\Component\DomCrawler\Crawler;

class ChannelCest
{
    public function testExtractHour(Tester $I)
    {
        $html = '<select name="selected_channel"><option value="val">text</option></select>';

        $I->assertEquals(
            [["val" => "text"]],
            (new Channels(new Crawler(), $html))->get()
        );
    }
}

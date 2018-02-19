<?php
namespace Parser;

use App\Vsetv\Parser\Channels;
use FunctionalTester as Tester;
use Symfony\Component\DomCrawler\Crawler;

class ChannelCest
{
    public function testExtractChannelNameAndId(Tester $I)
    {
        $html = '<select name="selected_channel"><option value="val">text</option></select>';

        $I->assertEquals(
            [["val" => "text"]],
            (new Channels(new Crawler(), $html))->get()
        );
    }

    public function testExtractChannelNameAndIdForEmptyString(Tester $I)
    {
        $html = '';

        $I->assertEquals(
            [],
            (new Channels(new Crawler(), $html))->get()
        );
    }
}

<?php

namespace VseTv;

use App\VseTv\ChannelsParser;
use FunctionalTester as Tester;
use Symfony\Component\DomCrawler\Crawler;

class ChannelParserCest
{
    public function testExtractChannelNameAndId(Tester $I)
    {
        $html = '<select name="selected_channel"><option value="val">text</option></select>';

        $I->assertEquals(
            ["val" => "text"],
            (new ChannelsParser(new Crawler(), $html))->get()
        );
    }

    public function testExtractChannelNameAndIdForEmptyString(Tester $I)
    {
        $html = '';

        $I->assertEquals(
            [],
            (new ChannelsParser(new Crawler(), $html))->get()
        );
    }
}

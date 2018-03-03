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

        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $I->assertEquals(
            ["val" => "text"],
            (new ChannelsParser($crawler))->getChannels()
        );
    }

    public function testExtractChannelNameAndIdForEmptyString(Tester $I)
    {
        $html = '';

        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $I->assertEquals(
            [],
            (new ChannelsParser($crawler))->getChannels()
        );
    }
}

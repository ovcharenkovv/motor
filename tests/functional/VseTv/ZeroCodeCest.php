<?php

namespace VseTv;

use App\VseTv\ZeroCode;
use FunctionalTester as Tester;
use Symfony\Component\DomCrawler\Crawler;

class ZeroCodeCest
{
    public function testExtractZeroCode(Tester $I)
    {
        $html = '<div class="time"><img src="/pic/o0.gif">6:1<img src="/pic/o0.gif"></div>';
        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $I->assertEquals(
            "o0",
            (new ZeroCode($crawler))
        );
    }

    public function testExtractZeroCodeNotFirst(Tester $I)
    {
        $html = '<div class="time">05:00</div><div class="time"><img src="/pic/f1.gif">6:1<img src="/pic/o0.gif"></div>';
        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $I->assertEquals(
            "f1",
            (new ZeroCode($crawler))
        );
    }

    public function testExtractZeroCodeEmpty(Tester $I)
    {
        $html = '<div class="time"></div>';
        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $I->assertEquals(
            "",
            (new ZeroCode($crawler))
        );
    }
}

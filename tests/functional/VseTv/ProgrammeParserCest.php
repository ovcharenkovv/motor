<?php

namespace VseTv;

use App\VseTv\ProgrammeParser;
use FunctionalTester as Tester;
use Symfony\Component\DomCrawler\Crawler;

class ProgrammeParserCest
{

    public function testExtractProgrammeForEmptyHtml(Tester $I)
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent('');

        $I->assertEquals(
            [],
            (new ProgrammeParser($crawler))->getProgramme()
        );
    }


    public function testExtractProgrammeForEmptyDomList(Tester $I)
    {
        $html = '
            <a name="day1"></a><a name="day2"></a>
            <a name="day3"></a><a name="day4"></a>
            <a name="day5"></a><a name="day6"></a>
            <a name="day5"></a><a name="day6"></a>
            <a name="day6"></a><a name="day7"></a>
            <a name="day7"></a><a class="clearshed"></a>
        ';
        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $I->assertEquals(
            [],
            (new ProgrammeParser($crawler))->getProgramme()
        );
    }

    public function testExtractProgrammeForChangeDomElementWithId(Tester $I)
    {
        $html = '
            <a name="day1"></a>
                <div id="schedule_container_new">
                    <div class="time">time</div>
                    <div class="prname2">title</div>
                </div>
                <div class="schedule_container">
                    <div class="time">time2</div>
                    <div class="prname2">title2</div>
                </div>
                <div class="time">time3</div>
                <div class="prname2">title3</div>
            <a name="day2"></a>
        ';

        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $expected = ['time', 'title', 'time2', 'title2'];

        $I->assertEquals(
            $expected,
            (new ProgrammeParser($crawler))->getProgramme()
        );
    }

    public function testExtractProgrammeForOneDay(Tester $I)
    {
        $html = '
            <a name="day1"></a>
                <div id="schedule_container">
                    <div class="time">time</div>
                    <div class="prname2">title</div>
                </div>
            <a name="day2"></a>
        ';

        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $expected = ['time', 'title'];

        $I->assertEquals(
            $expected,
            (new ProgrammeParser($crawler))->getProgramme()
        );
    }

    public function testExtractProgrammeForTwoDay(Tester $I)
    {
        $html = '
            <a name="day1"></a>
                <div id="schedule_container">
                    <div class="time">time</div>
                    <div class="prname2">title</div>
                </div>
            <a name="day2"></a>
                <div id="schedule_container">
                    <div class="time">time2</div>
                    <div class="prname2">title2</div>
                </div>
            <a name="day3"></a>
        ';

        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $expected = ['time', 'title', 'time2', 'title2'];

        $I->assertEquals(
            $expected,
            (new ProgrammeParser($crawler))->getProgramme()
        );
    }
}

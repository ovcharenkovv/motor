<?php
namespace Parser;

use App\VseTv\TimeExtractor;
use FunctionalTester as Tester;

class TimeExtractorCest
{

    /**
     * @example ["05:00", "<img src=\"/pic/z7.gif\"><img src=\"/pic/z0.gif\">:<img src=\"/pic/z7.gif\"><img src=\"/pic/z7.gif\">"]
     * @example ["05:00", "0<img src=\"/pic/z0.gif\">:<img src=\"/pic/z7.gif\"><img src=\"/pic/z7.gif\">"]
     * @example ["05:00", "<img src=\"/pic/z7.gif\">5:<img src=\"/pic/z7.gif\"><img src=\"/pic/z7.gif\">"]
     * @example ["05:00", "<img src=\"/pic/z7.gif\"><img src=\"/pic/z0.gif\">:<img src=\"/pic/z7.gif\">0"]
     * @example ["05:00", "<img src=\"/pic/z7.gif\"><img src=\"/pic/z0.gif\">:0<img src=\"/pic/z7.gif\">"]
     * @example ["05:00", "<img src=\"/pic/z7.gif\"><img src=\"/pic/z0.gif\">:00"]
     * @example ["05:00", "05:00"]
     *
     */
    public function testExtractHour(Tester $I, \Codeception\Example $example)
    {
        $I->assertEquals(
            $example[0],
            (new TimeExtractor('z7'))->parse($example[1])
        );
    }
}

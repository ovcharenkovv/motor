<?php
namespace Parse;

use App\Parser\Vsetv\Extractor\Time;
use FunctionalTester as Tester;

class TimeCest
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
            (new Time('z7'))->parse($example[1])
        );
    }
}

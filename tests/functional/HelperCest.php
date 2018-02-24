<?php

use FunctionalTester as Tester;

class HelperCest
{
    /**
     * @example [0, "example",["hrdbr", "example"]]
     * @example [1, "example",["hrdbr", "xample"]]
     * @example [2, "example",["hrdbr", "ample"]]
     * @example [2, "hrdbr",["dbr", "ample"]]
     * @example [false, "dffdf",["hrdbr", "example"]]
     *
     */
    public function testStrposArr(Tester $I, \Codeception\Example $example)
    {
        $I->assertEquals(
            $example[0],
            strpos_arr($example[1], $example[2])
        );
    }
}

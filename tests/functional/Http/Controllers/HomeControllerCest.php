<?php
namespace Http\Controllers;

use FunctionalTester;

class HomeControllerCest
{
    public function testHealthCheck(FunctionalTester $I)
    {
        $I->amOnRoute('health-check');
        $I->seeResponseCodeIs(200);
        $I->see('It works!');
    }
}

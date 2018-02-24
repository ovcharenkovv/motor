<?php
namespace Http\Controllers;

use FunctionalTester;

class HomeControllerCest
{
    public function testHomeController(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->seeResponseCodeIs(200);
        $I->see('Hello world !!!');
    }
}

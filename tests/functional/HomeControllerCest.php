<?php


class HomeControllerCest
{
    public function tryTest(FunctionalTester $I)
    {
        $I->amOnRoute('home');
        $I->seeResponseCodeIs(200);
        $I->see('Hello world');
    }
}

<?php
namespace Models;

use FunctionalTester as Tester;

class FactoryCest
{
    public function testCreateChannel(Tester $I)
    {
        $I->assertInstanceOf(\App\Models\Channel::class, $I->makeChannel());
    }
}

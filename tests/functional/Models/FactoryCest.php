<?php
namespace Models;

use FunctionalTester as Tester;

class FactoryCest
{
    public function testCreateChannel(Tester $I)
    {
        $I->assertInstanceOf(\App\Models\Channel::class, $I->makeChannel());
    }

    public function testCreateProgramme(Tester $I)
    {
        $I->assertInstanceOf(\App\Models\Programme::class, $I->makeProgramme());
    }

    public function testCreateScrapChannel(Tester $I)
    {
        $I->assertInstanceOf(\App\Models\ScrapChannel::class, $I->makeScrapChannel());
    }
}

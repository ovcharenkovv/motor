<?php

namespace Models;

use App\Models\ScrapChannel;
use FunctionalTester as Tester;

/**
 * @property \Faker\Generator faker
 */
class ScrapChannelsCest
{
    private $channels;

    public function _before(Tester $I)
    {
        $this->faker = \Faker\Factory::create();
    }

    public function testDoNotSaveScrapChannel(Tester $I)
    {
        $name = $this->faker->word;

        (new ScrapChannel())->saveChannels(["random" => $name]);

        $I->assertEmpty(
            ScrapChannel::whereName($name)->count()
        );
    }

    public function testSaveScrapChannel(Tester $I)
    {
        $name = $this->faker->word;

        (new ScrapChannel())->saveChannels(["channel_123" => $name]);

        $I->assertNotEmpty(
            ScrapChannel::whereName($name)->count()
        );
    }

    public function testCleanCopies(Tester $I)
    {
        $name = $this->faker->word;
        $nameHd = $name . ' HD';

        $I->makeScrapChannel(['name' => $name, 'url' => 'http://www.vsetv.com/schedule_channel_1_week.html']);
        $I->makeScrapChannel(['name' => $nameHd, 'url' => 'http://www.vsetv.com/schedule_channel_2_week.html']);

        (new ScrapChannel())->cleanCopies();

        $I->assertNotEmpty(
            ScrapChannel::whereName($name)->count()
        );

        $I->assertEmpty(
            ScrapChannel::whereName($nameHd)->count()
        );
    }
}

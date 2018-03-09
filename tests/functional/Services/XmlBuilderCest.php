<?php

namespace Services;

use App\Models\Channel;
use App\Services\XmlTvBuilder;
use FunctionalTester as Tester;

/**
 * @property XmlTvBuilder xmlBuilder
 */
class XmlBuilderCest
{
    public function _before()
    {
        $this->xmlBuilder = new XmlTvBuilder;
    }


    public function testBuildHeader(Tester $I)
    {
        $expected = <<<TAG
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE tv SYSTEM "xmltv.dtd">
<tv generator-info-url="http://www.xmltv.org/" generator-info-name="Schedules Direct"/>\n
TAG;
        $result = $this->xmlBuilder->getXml();

        $I->assertEquals($expected, $result);
    }

    public function testBuildWithoutData(Tester $I)
    {
        $expected = <<<TAG
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE tv SYSTEM "xmltv.dtd">
<tv generator-info-url="http://www.xmltv.org/" generator-info-name="Schedules Direct"/>\n
TAG;
        $result = $this->xmlBuilder->getXml();

        $I->assertEquals($expected, $result);
    }

    public function testBuildWithOutProgramme(Tester $I)
    {
        $channel = $I->makeChannel();

        $expected = <<<TAG
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE tv SYSTEM "xmltv.dtd">
<tv generator-info-url="http://www.xmltv.org/" generator-info-name="Schedules Direct"><channel id="{$channel->id}"><display-name>{$channel->display_name}</display-name><icon src="{$channel->icon_src}"/></channel></tv>\n
TAG;

        $this->xmlBuilder->addChannels(Channel::whereId($channel->id)->get());
        $result = $this->xmlBuilder->getXml();

        $I->assertEquals($expected, $result);
    }


    public function testBuildWithChannelAndProgramme(Tester $I)
    {
        $channel = $I->makeChannel();
        $programme = $I->makeProgramme(['channel_id' => $channel->id]);

        $expected = <<<TAG
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE tv SYSTEM "xmltv.dtd">
<tv generator-info-url="http://www.xmltv.org/" generator-info-name="Schedules Direct"><channel id="{$channel->id}"><display-name>{$channel->display_name}</display-name><icon src="{$channel->icon_src}"/></channel><programme start="{$programme->start->format("YmdHis +0300")}" stop="{$programme->stop->format("YmdHis +0300")}" channel="{$channel->id}"><title>{$programme->title}</title><category/></programme></tv>\n
TAG;

        $this->xmlBuilder->addChannels(Channel::whereId($channel->id)->get());
        $result = $this->xmlBuilder->getXml();

        $I->assertEquals($expected, $result);
    }

}

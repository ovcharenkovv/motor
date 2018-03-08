<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMImplementation;
use Illuminate\Database\Eloquent\Collection;

class XmlTvBuilder
{

    /**
     * @var Collection
     */
    private $channels;

    /**
     * @var string
     */
    private $xml;

    /**
     * @var DOMDocument
     */
    private $dom;

    /**
     * Build xml and save in private property
     */
    private function build()
    {
        $imp = new DOMImplementation;
        $this->buildHeader($imp);
        $tv = $this->addTv();

        foreach ($this->channels as $channelModel) {
            $channel = $this->addChannel($channelModel);
            $tv->appendChild($channel);

            foreach ($channelModel->programmes as $programme) {
                $programme = $this->addProgramme($programme);
                $tv->appendChild($programme);
            }
        }

        $this->dom->appendChild($tv);
        $this->xml = $this->dom->saveXML();
    }

    /**
     * @param DOMImplementation $imp
     */
    private function buildHeader(DOMImplementation $imp)
    {
        $dtd = $imp->createDocumentType('tv', '', 'xmltv.dtd');
        $this->dom = $imp->createDocument("", "", $dtd);
        $this->dom->encoding = 'UTF-8';
    }

    /**
     * @return DOMElement
     */
    private function addTv(): DOMElement
    {
        $tv = $this->dom->createElement('tv');
        $tv->setAttribute('generator-info-url', "http://www.xmltv.org/");
        $tv->setAttribute('generator-info-name', "Schedules Direct");

        return $tv;
    }

    /**
     * @param $programmeModel
     * @return DOMElement
     */
    private function addProgramme($programmeModel): DOMElement
    {
        $programme = $this->dom->createElement('programme');
        $programme->setAttribute("start", $programmeModel->start->format("Ymdhms +0000"));
        $programme->setAttribute("stop", $programmeModel->stop->format("Ymdhms +0300"));
        $programme->setAttribute("channel", $programmeModel->channel_id);

        $title = $this->dom->createElement('title', $programmeModel->title);
        $programme->appendChild($title);

        $category = $this->dom->createElement('category');
        $programme->appendChild($category);

        return $programme;
    }

    /**
     * @param $channelModel
     * @return DOMElement
     */
    private function addChannel($channelModel): DOMElement
    {
        $channel = $this->dom->createElement('channel');
        $channel->setAttribute("id", $channelModel->id);

        $displayName = $this->dom->createElement('display-name', $channelModel->display_name);
        $channel->appendChild($displayName);

        $icon = $this->dom->createElement('icon');
        $icon->setAttribute("src", "http://www.vsetv.com/pic/channel_logos/403.gif");
        $channel->appendChild($icon);

        return $channel;
    }

    /**
     * @param Collection $channels
     */
    public function addChannels(Collection $channels)
    {
        $this->channels = $channels;
    }

    /**
     * @return mixed
     */
    public function getXml(): string
    {
        $this->build();

        return $this->xml;
    }
}

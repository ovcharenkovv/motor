<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMImplementation;
use Illuminate\Database\Eloquent\Collection;

class XmlTvBuilder
{
    /**
     * @var array
     */
    private $config = [
        'header' => [
            'dtd' => 'xmltv.dtd',
            'encoding' => 'UTF-8'
        ],
        'generator-info' => [
            'url' => 'http://www.xmltv.org/',
            'name' => 'Schedules Direct'
        ]
    ];
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
        $dtd = $imp->createDocumentType('tv', '', data_get($this->config, 'header.dtd'));
        $this->dom = $imp->createDocument("", "", $dtd);
        $this->dom->encoding = data_get($this->config, 'header.encoding');
    }

    /**
     * @return DOMElement
     */
    private function addTv(): DOMElement
    {
        $tv = $this->dom->createElement('tv');
        $tv->setAttribute('generator-info-url', data_get($this->config, 'generator-info.url'));
        $tv->setAttribute('generator-info-name', data_get($this->config, 'generator-info.name'));

        return $tv;
    }

    /**
     * @param $programmeModel
     * @return DOMElement
     */
    private function addProgramme($programmeModel): DOMElement
    {
        $programme = $this->dom->createElement('programme');
        $programme->setAttribute("start", $programmeModel->start->format("YmdHis +0300"));
        $programme->setAttribute("stop", $programmeModel->stop->format("YmdHis +0300"));
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
        $icon->setAttribute("src", $channelModel->icon_src);
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

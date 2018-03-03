<?php

namespace App\VseTv;

use Symfony\Component\DomCrawler\Crawler;

class ChannelsParser
{

    /**
     * @var array
     */
    private $channels = [];

    /**
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $crawler->filterXPath("//select[@name='selected_channel']/option")->each(function ($node) {
            $this->channels[current($node->extract('value'))] = current($node->extract('_text'));
        });
    }

    /**
     * @return mixed
     */
    public function getChannels(): array
    {
        return $this->channels;
    }
}

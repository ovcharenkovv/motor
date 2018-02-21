<?php

namespace App\Vsetv\Parser;

use Symfony\Component\DomCrawler\Crawler;

class Channels
{

    /**
     * @var array
     */
    private $channels = [];

    /**
     * @param Crawler $crawler
     * @param $html
     */
    public function __construct(Crawler $crawler, string $html)
    {
        $crawler->addHtmlContent($html);

        $crawler->filterXPath("//select[@name='selected_channel']/option")->each(function ($node) {
            $this->channels[current($node->extract('value'))] = current($node->extract('_text'));
        });
    }

    /**
     * @return mixed
     */
    public function get(): array
    {
        return $this->channels;
    }
}

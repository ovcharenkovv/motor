<?php

namespace App\VseTv;

use Symfony\Component\DomCrawler\Crawler;

class ZeroCode
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $list = $this->crawler->filter('.time img');

        return $list->count() ? substr($list->first()->attr('src'), -6, 2) : "";
    }
}

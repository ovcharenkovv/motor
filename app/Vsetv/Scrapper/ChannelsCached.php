<?php

namespace App\Vsetv\Scrapper;

use Illuminate\Support\Facades\Cache;

class ChannelsCached
{
    /**
     * @var string
     */
    private $cacheKey = 'channels_html';

    /**
     * @var string
     */
    private $html;

    /**
     * @return static
     */
    private function getTTl()
    {
        return now()->endOfWeek();
    }

    /**
     * @param Channels $channelScrapper
     */
    public function __construct(Channels $channelScrapper)
    {
        $this->html = (string)Cache::remember($this->cacheKey, $this->getTTl(), function () use ($channelScrapper) {
            return $channelScrapper;
        });
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->html;
    }
}

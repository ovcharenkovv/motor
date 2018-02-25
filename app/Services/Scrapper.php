<?php

namespace App\Services;

use Goutte\Client;
use Illuminate\Support\Facades\Cache;

class Scrapper
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @return static
     */
    private function getTTl()
    {
        return now()->endOfWeek();
    }

    /**
     * Scrapper constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    /**
     * @param string $url
     * @param bool $useCache
     * @return string
     */
    public function do(string $url, bool $useCache = true): string
    {
        return Cache::remember($url, $useCache ? $this->getTTl() : 0, function () use ($url) {
            return $this->client->request('GET', $url)->html();
        });
    }
}

<?php

namespace App\Services;

use Goutte\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class Scrapper
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @return Carbon
     */
    private function getTTl() : Carbon
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
     * @return mixed
     */
    private function requestAndCache(string $url)
    {
        if (!Cache::has($url)) {
            Cache::put($url, $this->request($url), $this->getTTl());
        }

        return Cache::get($url);
    }

    /**
     * @param string $url
     * @return string
     */
    private function request(string $url): string
    {
        return $this->client->request('GET', $url)->html();
    }

    /**
     * @param string $url
     * @param bool $useCache
     * @return string
     */
    public function do(string $url, bool $useCache = true): string
    {
        return $useCache ? $this->requestAndCache($url) : $this->request($url);
    }
}

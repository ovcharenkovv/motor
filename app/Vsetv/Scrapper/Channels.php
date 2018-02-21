<?php

namespace App\Vsetv\Scrapper;

use Goutte\Client;

class Channels
{
    /**
     * @var string
     */
    private $url = 'http://www.vsetv.com/channels.html';

    /**
     * @var string
     */
    private $html;


    /**
     * Channels constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->html = $client->request('GET', $this->url)->html();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->html;
    }
}

<?php

namespace App\Vsetv\Scrapper;

use Goutte\Client;

class Programme
{
    /**
     * @var string
     */
    private $html;


    /**
     * Channels constructor.
     * @param Client $client
     */
    public function __construct(Client $client, $html)
    {
        $this->html = $client->request('GET', $html)->html();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->html;
    }
}

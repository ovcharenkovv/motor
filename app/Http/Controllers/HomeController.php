<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Contracts\Cache\Repository as CacheManager;

class HomeController extends Controller
{

    public function index(CacheManager $cache)
    {
        if ($cache->has('sony_html')) {
            $html = $cache->get('sony_html');
        } else {
            $client = new Client();
            $html = $client->request('GET', 'http://www.vsetv.com/schedule_channel_403_week.html')->html();

            $expiresAt = now()->addMinutes(10);
            $cache->put('sony_html', $html, $expiresAt);
        }

        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $crawler->filter('.time img')->each(function ($node) {
            print $node->attr('src')."<br>";
        });

        return 'Hello world !!!';
    }
}

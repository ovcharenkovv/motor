<?php

namespace App\Http\Controllers;

use Goutte\Client;

class HomeController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'http://www.vsetv.com/schedule_printversion_withdesc.html');
        $result = '';

        $crawler->filter('.prname2')->each(
            function ($node, $result) {
                $result .= $node->text() . "\n";
            }
        );

        return $result;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class HomeController extends Controller
{
    public function index()
    {

        $client = new Client();
        $crawler = $client->request('GET', 'http://www.vsetv.com/schedule_printversion_withdesc.html');
        $crawler->filter('.prname2')->each(function ($node) {
            print $node->text()."\n";
        });

        return "sdfdfd";

    }
}

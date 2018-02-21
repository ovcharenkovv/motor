<?php

namespace App\Http\Controllers;

use App\Models\ScrapChannel;
use Illuminate\Contracts\Cache\Repository as CacheManager;

class HomeController extends Controller
{

    public function index(CacheManager $cache)
    {
        echo "<pre>";
        print_r(ScrapChannel::all()->toArray());

        return 'Hello world !!!';
    }
}

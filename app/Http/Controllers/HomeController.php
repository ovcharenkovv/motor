<?php

namespace App\Http\Controllers;

use App\Models\ScrapChannel;

class HomeController extends Controller
{

    public function index()
    {
        echo "<pre>";
        print_r(ScrapChannel::all()->toArray());

        return 'Hello world !!!';
    }
}

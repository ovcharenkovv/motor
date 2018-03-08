<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Services\XmlTvBuilder;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(XmlTvBuilder $xmlBuilder)
    {
        $channels = Channel::all();
        $xmlBuilder->addChannels($channels);
        Storage::disk('xmltv')->put('xmltv.xml', $xmlBuilder->getXml());
    }
}

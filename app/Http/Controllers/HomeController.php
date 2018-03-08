<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Services\XmlTvBuilder;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * @return string
     */
    public function index(XmlTvBuilder $xmlBuilder)
    {
        $channels = Channel::all();
        $xmlBuilder->addChannels($channels);

        return response($xmlBuilder->getXml(), 200, array('content-type' => 'application/octet-stream'));
    }

    /**
     * @param XmlTvBuilder $xmlBuilder
     */
    public function update(XmlTvBuilder $xmlBuilder)
    {
        $channels = Channel::all();
        $xmlBuilder->addChannels($channels);
        Storage::disk('public')->put('xmltv.xml', $xmlBuilder->getXml());
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function xmlTvFile()
    {
        $file = Storage::disk('public')->get('xmltv.xml');

        return response($file, 200, array('content-type' => 'application/octet-stream'));
    }
}

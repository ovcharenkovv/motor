<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Services\XmlTvBuilder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * @return string
     */
    public function healthCheck()
    {
        return "It works!";
    }


    /**
     * @param XmlTvBuilder $xmlBuilder
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function xmlTvFile(XmlTvBuilder $xmlBuilder)
    {
        Artisan::call('parse:channels');

        $xmlBuilder->addChannels(Channel::all());

        return response(
            gzencode($xmlBuilder->getXml()),
            200,
            array('content-type' => 'application/octet-stream')
        );
    }
}

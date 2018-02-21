<?php

namespace App\Console\Commands;

use App\Models\ScrapChannel;
use App\Vsetv\Parser\Channels as ChannelsParser;
use App\Vsetv\Scrapper\Channels as ChannelsScrapper;
use App\Vsetv\Scrapper\ChannelsCached as ChannelScrapperCached;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ParseChannels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:channels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Channels';
    /**
     * @var ChannelsScrapper
     */
    private $channelsScrapper;
    /**
     * @var Crawler
     */
    private $crawler;


    /**
     * Create a new command instance.
     *
     * ParseChannels constructor.
     * @param ChannelsScrapper $channelsScrapper
     * @param Crawler $crawler
     */
    public function __construct(ChannelsScrapper $channelsScrapper, Crawler $crawler)
    {
        parent::__construct();

        $this->channelsScrapper = $channelsScrapper;
        $this->crawler = $crawler;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $html = new ChannelScrapperCached($this->channelsScrapper);
        $channels = (new ChannelsParser($this->crawler, $html))->get();

        (new ScrapChannel())->saveChannels($channels);

//        dd($channels);
    }
}

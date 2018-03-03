<?php

namespace App\Console\Commands;

use App\Models\ScrapChannel;
use App\Services\Scrapper;
use App\VseTv\ChannelsParser;
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
     * @var Crawler
     */
    private $crawler;
    /**
     * @var Scrapper
     */
    private $scrapper;


    /**
     * Create a new command instance.
     *
     * ParseChannels constructor.
     * @param Scrapper $scrapper
     * @param Crawler $crawler
     */
    public function __construct(Scrapper $scrapper, Crawler $crawler)
    {
        parent::__construct();
        $this->scrapper = $scrapper;
        $this->crawler = $crawler;
    }


    /**
     * @throws \Exception
     */
    public function handle()
    {
        $html = $this->scrapper->do('http://www.vsetv.com/channels.html');
        $channels = (new ChannelsParser($this->crawler, $html))->get();

        (new ScrapChannel())->saveChannels($channels);
        (new ScrapChannel())->cleanCopies();
        $this->info('Channel list has been parsed');
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Channel;
use App\Models\Programme;
use App\Services\Scrapper;
use App\VseTv\ProgrammeParser;
use App\VseTv\ProgrammeTransform;
use App\VseTv\ZeroCode;
use Codeception\Module\Db;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ParseProgramme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:programme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Programme';

    /**
     * @var Scrapper
     */
    private $scrapper;

    /**
     * Create a new command instance.
     *
     * ParseChannels constructor.
     * @param Scrapper $scrapper
     */
    public function __construct(Scrapper $scrapper)
    {
        parent::__construct();

        $this->scrapper = $scrapper;
    }


    /**
     * @throws \Exception
     */
    public function handle()
    {
        $channel = Channel::firstOrCreate(['display_name' => 'Sony Sci-Fi']);

        $html = $this->scrapper->do('http://www.vsetv.com/schedule_channel_403_week.html', true);
        $crawler = new Crawler();
        $crawler ->addHtmlContent($html);

        $parseResult = (new ProgrammeParser($crawler))->getProgramme();

        $zero = (string) new ZeroCode($crawler);

        $weekProgramme = (new ProgrammeTransform($parseResult, $zero, $channel->id))->getProgramme();

        Programme::truncate();
        Programme::insert($weekProgramme);

        $this->info('Programme has been parsed and saved');
    }
}

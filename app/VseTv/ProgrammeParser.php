<?php

namespace App\VseTv;

use Symfony\Component\DomCrawler\Crawler;

class ProgrammeParser
{
    /**
     * @var array
     */
    private $programme = [];
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var array
     */
    private $daysSelectors = [
        '//a[@name="day1"]' => 'day2',
        '//a[@name="day2"]' => 'day3',
        '//a[@name="day3"]' => 'day4',
        '//a[@name="day4"]' => 'day5',
        '//a[@name="day5"]' => 'day6',
        '//a[@name="day6"]' => 'day7',
        '//a[@name="day7"]' => 'clearshed',
    ];

    /**
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @param array $programme
     * @param Crawler $node
     */
    protected function parseTime(array &$programme, Crawler $node)
    {
        if ($node->attr('class') == 'time') {
            $programme[] = $node->html();
        }
    }

    /**
     * @param array $programme
     * @param Crawler $node
     */
    protected function parseTitle(array &$programme, Crawler $node)
    {
        if ($node->attr('class') == 'prname2') {
            $programme[] = $node->text();
        }
    }

    /**
     * @param Crawler $node
     * @return bool
     */
    protected function doNotParse(Crawler $node): bool
    {
        return !$node->count() || !$node->nextAll()->count();
    }

    /**
     * @param Crawler $node
     * @param string $to
     * @return bool
     */
    protected function stopParsing(Crawler $node, string $to): bool
    {
        return $node->attr('name') == $to || $node->attr('class') == $to;
    }

    /**
     * @param string $from
     * @param string $to
     * @return array
     */
    protected function getDayProgramme(string $from, string $to): array
    {
        $programme = [];

        $node = $this->crawler->filterXPath($from)->first();

        if ($this->doNotParse($node)) {
            return $programme;
        }

        while ($node = $node->nextAll()) {
            $node->children()->each(function ($node) use (&$programme) {
                $this->parseTime($programme, $node);
                $this->parseTitle($programme, $node);
            });

            if ($this->stopParsing($node, $to)) {
                break;
            }
        }

        return $programme;
    }

    /**
     * @return mixed
     */
    public function getProgramme(): array
    {
        foreach ($this->daysSelectors as $from => $to) {
            $this->programme = array_merge(
                $this->programme,
                $this->getDayProgramme($from, $to)
            );
        }

        return $this->programme;
    }
}

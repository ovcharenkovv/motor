<?php

namespace App\VseTv;

use Illuminate\Support\Carbon;

class ProgrammeTransform
{
    /**
     * @var array
     */
    private $parseResult;
    /**
     * @var
     */
    private $programme;
    /**
     * @var string
     */
    private $zero;
    /**
     * @var int
     */
    private $channelId;

    /**
     * ProgrammePrepare constructor.
     *
     * @param array $parseResult
     * @param string $zero
     * @param int $channelId
     */
    public function __construct(array $parseResult, string $zero, int $channelId)
    {
        $this->parseResult = $parseResult;
        $this->zero = $zero;
        $this->channelId = $channelId;

        $this->convertFlattArrayToCollection();
        $this->convertStartTimeToDataTime();
        $this->getStopTimeFromPrevious();
    }

    /**
     * @return array
     */
    public function getProgramme(): array
    {
        return $this->programme;
    }

    /**
     * @param $item
     * @return string
     */
    private function convertGifToTime($item): string
    {
        return (new TimeExtractor($this->zero))->parse($item);
    }

    /**
     * ["<img src="/pic/0f.gig">5:00","Programme name"]
     * become
     * [['start' => '05:00', 'name' => 'Programme name']]
     */
    private function convertFlattArrayToCollection()
    {
        $result = array_chunk($this->parseResult, 2);

        foreach ($result as &$item) {
            $this->programme[] = [
                'start' => $this->convertGifToTime($item[0]),
                'title' => $item[1],
                'channel_id' => $this->channelId,
            ];
        }
    }

    /**
     * '05:00'
     * become
     * '2018-01-01 05:00'
     */
    private function convertStartTimeToDataTime()
    {
        $date = now()->startOfWeek();

        foreach ($this->programme as $key => &$item) {
            $item['start'] = $date->format("Y-m-d ") . $item['start'];

            $startTime = Carbon::parse($item['start']);
            $finishTime = Carbon::parse($this->programme[$key + 1]['start'] ?? $item['start']);

            if ($finishTime->diffInMinutes($startTime) > 200) {
                $date->addDay();
            }
        }
    }

    /**
     * [['start' => '05:00', 'name' => 'name']]
     * become
     * [['start' => '05:00', 'name' => 'name', "end" => "prev item"]]
     */
    private function getStopTimeFromPrevious()
    {
        foreach ($this->programme as $key => &$item) {
            $item['stop'] = $this->programme[$key + 1]['start'] ?? $this->programme[$key]['start'];
        }
    }
}

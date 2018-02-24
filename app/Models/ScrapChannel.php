<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScrapChannel extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'scrap_channels';
    /**
     * @var array
     */
    protected $toClean = ['HD', '(на укр.)', '(+2)', '(+3)', '(+4)', '(+5)', '(+6)', '(+7)'];

    /**
     * @param array $channels
     */
    public function saveChannels(array $channels)
    {
        $scrChannels = [];
        foreach ($channels as $key => $value) {
            if (strpos($key, 'channel_') !== false) {
                $scrChannels[] = [
                    'url' => 'http://www.vsetv.com/schedule_' . $key . '_week.html',
                    'name' => $value,
                ];
            }
        }

        ScrapChannel::insert($scrChannels);
    }

    /**
     * @throws \Exception
     */
    public function cleanCopies()
    {
        ScrapChannel::all()->reject(function ($channel) {
            return !strpos_arr($channel->name, $this->toClean);
        })->each(function ($item) {
            $item->delete();
        });
    }
}

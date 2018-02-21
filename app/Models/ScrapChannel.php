<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScrapChannel extends Model
{
    protected $table = 'scrap_channels';

    public function saveChannels(array $channels)
    {
        foreach ($channels as $key => $value) {
            if (strpos($key, 'channel_') !== false) {
                $scrChannels[] = [
                    'url' => 'http://www.vsetv.com/schedule_' . $key . '_week.html',
                    'name' => $value
                ];
            }
        }

        ScrapChannel::insert($scrChannels);
    }
}

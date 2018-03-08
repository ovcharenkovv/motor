<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['display_name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programmes()
    {
        return $this->hasMany(Programme::class, 'channel_id');
    }
}

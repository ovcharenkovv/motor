<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Factory extends \Codeception\Module
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function makeChannel(array $attributes = [])
    {
        return factory(\App\Models\Channel::class)->create($attributes);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function makeProgramme(array $attributes = [])
    {
        return factory(\App\Models\Programme::class)->create($attributes);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function makeScrapChannel(array $attributes = [])
    {
        return factory(\App\Models\ScrapChannel::class)->create($attributes);
    }
}

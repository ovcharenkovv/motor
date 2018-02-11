<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Models\Channel;
use App\Models\Programme;

class Factory extends \Codeception\Module
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function makeChannel(array $attributes = [])
    {
        return factory(Channel::class)->create($attributes);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function makeProgramme(array $attributes = [])
    {
        return factory(Programme::class)->create($attributes);
    }
}

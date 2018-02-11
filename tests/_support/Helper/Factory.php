<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Models\Channel;

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

}

<?php

namespace Larbrary\Tawk\Facades;

use Illuminate\Support\Facades\Facade;

class Tawk extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tawk';
    }
}

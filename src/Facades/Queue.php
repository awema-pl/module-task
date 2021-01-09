<?php

namespace AwemaPL\Task\Facades;

use AwemaPL\Task\Contracts\Task as TaskContract;
use Illuminate\Support\Facades\Facade;

class Task extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return TaskContract::class;
    }
}

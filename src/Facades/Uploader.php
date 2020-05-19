<?php

namespace niro\Uploads\Facades;

use Illuminate\Support\Facades\Facade;

class Uploader extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Uploader';
    }
}

<?php
namespace niro\Uploads\Facades;

use Illuminate\Support\Facades\Facade;

class HandlerContainer extends Facade{
    
    public static function getFacadeAccessor(){
        return 'HandlerContainer';
    }
}
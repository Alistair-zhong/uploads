<?php
namespace niro\uploads\Facades;

use Illuminate\Support\Facades\Facade;

class Uploads extends Facade{
    
    public function getFacadeAccessor(){
        return 'Uploader';
    }
}
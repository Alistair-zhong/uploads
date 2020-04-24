<?php
namespace niro\Uploads\Exceptions;

use Exception;

class HandlerException extends Exception {
    
    public static function invalidType($name){
        return new static("{$name} ,无效的名字");
    }

    public static function alreadyRegistered($name){
        return new static("{$name},该名字已存在");
    }

    public  static function classDoesNotExist($className){
        return new static("{$className},该类不存在");
    }

    public static function invalidClass($className){
        return new static("{$className},无效的类,必须实现niro\\Uploades\\Contracts\\HandleDataContract接口");
    }

}
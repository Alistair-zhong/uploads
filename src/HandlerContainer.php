<?php
namespace niro\Uploads;

use niro\Uploads\Exceptions\HandlerException;
use niro\Uploads\Contracts\HandleDataContract;

class HandlerContainer {
    /**
     * 已注册的处理类集合
     */
    private $handlers;

    public function __construct(){
        $this->handlers = collect();
    }

    /**
     * 根据名字获取处理类
     * @param string name 注册时的处理类的名称
     */
    public function getHandler(string $name){
        $className = $this->getHandlerClass($name);
        return  $this->getHandleInstance($className);
    }

    /**
     * 根据名字获取类名
     * @param string name 注册时的处理类的名称
     */
    public function getHandlerClass(string $name){
        return $this->handlers->get($name);
    }

    /**
     * 根据类名返回实例化对象
     * @param string className
     * @return HandleDataContract
     */
    public function getHandleInstance(string $className):HandleDataContract{
        return $className ? new $className : null ;
    }

    /**
     * 注册处理类数组  可同时注册多个
     * @param array handler
     */
    public function registerHandlers(array $handlers):void{
        foreach($handlers as $key => $value){
            $this->registerHandler($key,$value);
        }
    }

    /**
     * 注册单个处理类
     * @param string name
     * @param string className
     */
    public function registerHandler(string $name,string $className){
        if (!preg_match('/^[a-z0-9_]+$/', $name)) {
            throw HandlerException::invalidType($name);
        }  

        if($this->handlers->has($name)){
            throw HandlerException::alreadyRegistered($name);
        }

        if(! class_exists($className)){
            throw HandlerException::classDoesNotExist($className);
        }

        $instance = new $className;
        if(! ($instance instanceof HandleDataContract) ){
            throw HandlerException::invalidClass($className);
        }
        
        $this->handlers->put($name,$className);
        return $this;
    }

    /**
     * 调用注册的处理类进行处理数据
     * @param string $name 已注册的处理类名字
     * @param mixed  $data 要处理的数据
     */
    public function handleData(string $name,$data){

        $instance = $this->getHandler($name);
        if(is_null($instance)){
            return false;
        }

        $instance->handleData($data);
    }


    /**
     * 返回所有已注册的处理者
     */
    public function getAllHandlers(){
        return $this->handlers;
    }

}
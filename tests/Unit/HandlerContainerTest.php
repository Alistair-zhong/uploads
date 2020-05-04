<?php
namespace niro\Uploads\Tests\Unit;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;
use niro\Uploads\Facades\HandlerContainer;
use niro\Uploads\UploadBaseServiceProvider;

class HandlerContainerTest extends TestCase {

    private $container;

    public function setUp():void{
        parent::setUp();
        $this->container = app('HandlerContainer');

    }
    
    /**
     * @test
     */
    public function a_custom_handler_can_be_registered(){
        $this->assertNotNull($this->container);
        $this->registerHandler();
        dump($this->container->getHandlers());
        $this->assertCount(1,$this->container->getHandlers());
    }


    /**
     * 注册自定义处理类
     */
    public function registerHandler(){
        $handlers = $this->parseDirFiles2Array(__DIR__ . "/../FakerClasses/");
        dd($handlers);
        $this->container->registerHandlers($handlers);
    }

    /**
     * 获取test/FakerClasses 目录下的文件，并构建可注册的键值对数组
     */
    public function parseDirFiles2Array($path){
        $files = collect(scandir($path))->filter(function($item,$key){
            return !in_array($item,['.','..']);
        });
        // TODO  排除文件夹
        $handlers = collect();
        $namespace = "niro\Uploads\Tests\FakerClasses\\";

        $files->each(function($item,$key)use($handlers,$namespace){
        $handlers->push($this->getFirstWord(Str::camel($item)),$namespace . Str::of($item)->replace('.php',''));
        });
        return $handlers;
    }

    public function getFirstWord($str){
        preg_match('/^([^A-Z]*)[A-Z]/',$str,$res);
        return $res[1];
    }

    /**
     * 加载google drive 的service provider
     */
    protected function getPackageProviders($app){
        return [
            UploadBaseServiceProvider::class,
        ];
    }
}
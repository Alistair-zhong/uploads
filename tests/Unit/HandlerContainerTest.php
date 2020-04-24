<?php
namespace niro\Uploads\Tests\Unit;

use Orchestra\Testbench\TestCase;

class HandlerContainerTest extends TestCase {

    private $contaienr;

    public function setUp():void{
    
    }

    /**
    * @test
    */
    public function can_new_NUll_be_a_object(){
        // $this->container = app('HandlerContainer');
        $this->container = new \niro\Uploads\HandlerContainer;
        $this->container->getHandler('name');
    }


    /**
     * 加载google drive 的service provider
     */
    public function getPackageProviders($app){
        return [
            // UploadBaseServiceProvider::class,
        ];
    }
}
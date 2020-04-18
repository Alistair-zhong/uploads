<?php
namespace niro\Uploads\Tests\Unit;

// use niro\Uploads\Tests\TestCase;

use Orchestra\Testbench\TestCase;
use niro\Uploads\Providers\GoogleDriveServiceProvider;


class InitTest extends TestCase{
    // use ConfigGoogle;
    // 读取google drive中的配置，并对service provider进行extend

    public function setUp():void{
        parent::setUp();
        // $this->getEnvironmentSetUp($app);
    }
    
    /**
    *@test
    */
    public function configGoogle_fun_can_run_properly(){
        // dump($this->configGoogle());
        // dump(require(__DIR__ . "/../config/googledrive.php"));
        $this->assertTrue(true);
    }

//========================================= 配置部分========================
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->push('filesytem.disks',$this->configGoogle());
    }

    protected function configGoogle(){
        return require(__DIR__ . "/../config/googledrive.php");
    }

    /**
     * 加载google drive 的service provider
     */
    public function getPackageProviders($app){
        return [
            GoogleDriveServiceProvider::class,
        ];
    }
}
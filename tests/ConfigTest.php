<?php
namespace niro\Uploads\Tests;

trait ConfigGoogle {
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

 
}
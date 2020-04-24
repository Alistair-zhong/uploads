<?php

namespace niro\Uploads;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;


class UploadBaseServiceProvider extends ServiceProvider{
    public function boot(){
        $this->registerPublish();
        $this->registerRoutes();
    }
    
    public function register(){
        $this->registerFacades();
    }


    public function registerFacades(){
        $this->app->singleton('Uploader',function($app){
            return new \niro\Uploads\Uploader\Uploader;
        });
        $this->app->singleton('HandlerContainer',function($app){
            return new \niro\Uploads\HandlerContainer;
        });

    }

    private function registerRoutes(){
        Route::group($this->routeConfiguration(),function(){
            $this->loadRoutesFrom(__DIR__ . "/../routes/web.php");
        });
    }

    private function routeConfiguration(){
        return [
            'prefix'        => 'google',
            'as'            => 'google.',
            'namespace'     => "niro\Uploads\Http\Controllers"
        ];  
    }

    public function registerPublish(){
        $this->publishes([
            __DIR__ . "/../config/uploads.php"                  => config_path('uploads.php'),
            __DIR__ . "/../stubs/UploadServiceProvider.stub"    => app_path('Providers/UploadServiceProvider.php',)
        ],'uploads-config');
        
        $this->publishes([
            __DIR__ . "/../resources/views/uploads.blade.php"       => resource_path('views/test/uploads.blade.php'),
            __DIR__ . "/../resources/assets/bootstrap"              => public_path('bootstrap'),
            __DIR__ . "/../stubs/GoogleDriveServiceProvider.stub"   => app_path('Providers/GoogleDriveServiceProvider.php'),
            __DIR__ . "/Http/Controllers/GoogleDriveController.php" => app_path('Http/Controllers/GoogleDriveController.php'),
        ],'uploads-google');
    }




}
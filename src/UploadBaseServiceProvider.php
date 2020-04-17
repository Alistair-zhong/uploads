<?php

namespace niro\uploads;

use Illuminate\Support\ServiceProvider;


class UploadBaseServiceProvider extends ServiceProvider{
    public function boot(){

        $this->registerPublish();
        $this->registerFacades();
        $this->registerRoutes();
    }

    public function register(){
        
    }


    public function registerFacades(){
        $this->app->bind('Uploader',function($app){
            return new niro\uploads\Uploader\Uploader;
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
            'namespace'     => 'niro\uploads\Http\Controller\\'
        ];  
    }

    public function registerPublish(){
        $this->publishes([
            __DIR__ . "/../config/uploads.php" => config_path('uploads.php'),
        ],'uploads-config');
    }









    // protected function registerPublish(){
    //     $this->publishes([
    //         __DIR__."/../config/parse.php"      => config_path('parse.php'),
    //         __DIR__."/../database/migrations/2020_04_05_000000_create_posts_table.php"  => database_path('migrations/2020_04_05_000000_create_posts_table.php'),
    //     ],'parse-config');
        
    //     $this->publishes([
    //         __DIR__."/Console/stubs/ParseServiceProvider.stub"  => app_path('Providers/ParseServiceProvider.php'),
    //     ],'parse-provider');
    // }
}
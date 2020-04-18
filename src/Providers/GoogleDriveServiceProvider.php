<?php 
namespace niro\Uploads\Providers;

use League\Flysystem\AdapterInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;

class GoogleDriveServiceProvider extends ServiceProvider{
    public function boot(){
        $client = new \Google_Client;
        $service = new \Google_Service_Drive($client);

        \Storage::extend('google', function ($app, $config) use ($service, $client) {
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);

            $adapter = new GoogleDriveAdapter($service, $config['folderId']);
            // $adapter = new GoogleDriveAdapter($service, $config['folderId']);
            
            return new \League\Flysystem\Filesystem($adapter, ['visibility' => AdapterInterface::VISIBILITY_PRIVATE]);
        });
    }

    public function register(){
        
    }
}
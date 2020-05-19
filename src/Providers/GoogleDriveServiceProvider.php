<?php

namespace niro\Uploads\Providers;

use League\Flysystem\AdapterInterface;
use Illuminate\Support\ServiceProvider;
use Masbug\Flysystem\GoogleDriveAdapter;

// use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;

class GoogleDriveServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->extendStorage();
    }

    public function register()
    {
        $this->registerConfiguration();
    }

    protected function extendStorage()
    {
        $client = new \Google_Client();
        $service = new \Google_Service_Drive($client);

        \Storage::extend('google', function ($app, $config) use ($service, $client) {
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);

            $adapter = new GoogleDriveAdapter($service, $config['folder']);
            // $adapter = new GoogleDriveAdapter($service, $config['folderId']);

            return new \League\Flysystem\Filesystem($adapter, ['visibility' => AdapterInterface::VISIBILITY_PRIVATE]);
        });
    }

    protected function registerConfiguration()
    {
        $this->app['config']->set('filesystems.disks', config('uploads.default_disk'));
    }

    protected function readCustomConfig()
    {
        return config('uploads.default_disk');
    }
}

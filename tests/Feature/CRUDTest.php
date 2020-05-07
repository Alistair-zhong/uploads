<?php

namespace niro\Uploads\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Orchestra\Testbench\TestCase;
use niro\Uploads\Jobs\GoogleUpload;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use niro\Uploads\UploadBaseServiceProvider;
use niro\Uploads\Providers\GoogleDriveServiceProvider;

class CRUDTest extends TestCase {

    private $store;

    public function setUp():void{
        parent::setUp();
        $this->store = Storage::disk('google');
    }
    /**
    *@test
    */
    public function a_file_can_be_upload_to_google_drive(){
        $image = UploadedFile::fake()->image(Str::random(10) . ".jpeg");

        $old_count = count($this->store->listContents());
        app('Uploader')->upload($image);
        $now_count = count($this->store->listContents());

        $this->assertEquals($old_count + 1, $now_count);
    }

    /**
    *@test
    */
    public function a_file_can_be_uploaded_through_controller(){
        $this->withoutExceptionHandling();

        $image = UploadedFile::fake()->image(Str::random(10) . ".jpeg");
        $old_count = count($this->store->listContents());

        $this->post(route('google.uploads'),[
            'upfile'    => $image,
        ])->assertStatus(200);
        $now_count = count($this->store->listContents());

        $this->assertEquals($old_count + 1, $now_count);
    }

    /**
    *@test
    */
    public function a_file_can_be_uploaded_in_queue_through_controller(){
        $this->withoutExceptionHandling();
        
        Queue::fake();
        Queue::assertNothingPushed();
        $image = UploadedFile::fake()->image(Hash::make(now()) . ".jpeg");
        $old_count = count($this->store->listContents());

        $this->post(route('google.uploads'),[
            'upfile'    => $image,
        ])->assertStatus(302);
        Queue::assertPushed(GoogleUpload::class,function(){
            // TODO 使用queue处理job
        });
        $now_count = count($this->store->listContents());

        $this->assertEquals($old_count + 1, $now_count);
    }

    /**
    *@test
    */
    public function can_get_all_files_in_root_dir(){
        dump($this->store->listContents());
        // dump(Storage::disk('google')->listContents());
    }

    /**
    *@test
    */
    public function path_is_cloudID(){
        dump($data = $this->store->getMetadata('1Wbty0Sjg45n8hnzsaKJMI4RiH2foi99N'));
        // $this->assertEquals('1Wbty0Sjg45n8hnzsaKJMI4RiH2foi99N',$data['path']);
    }

/**
    *@test
    */
    public function configGoogle_fun_can_run_properly(){
        $config = $this->configGoogle();
        $this->assertTrue(is_array($config));

        $first_key = array_key_first($config);
        dump(app()['config']);
        $this->assertTrue(isset(app()['config']));
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

        $app['config']->set('filesystems.disks.google',$this->configGoogle()['google']);
        $app['config']->set('filesystems.disks.local',['driver' => 'local',
        'root' => storage_path('app'),]);
    }

    protected function configGoogle():array{
        return require(__DIR__ . "/../config/googledrive.php");
    }

    /**
     * 加载google drive 的service provider
     */
    public function getPackageProviders($app){
        return [
            GoogleDriveServiceProvider::class,
            UploadBaseServiceProvider::class,
        ];
    }
}
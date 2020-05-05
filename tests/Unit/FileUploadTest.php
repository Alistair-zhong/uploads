<?php
namespace niro\Uploads\Tests\Unit;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Storage;
use niro\Uploads\UploadBaseServiceProvider;

class FileUploadTest extends TestCase{
    private $store;

    public function setUp():void{
        parent::setUp();

        $this->store = Storage::fake('google');
    }
    /**
    * @test
    */
    public function see_the_result_of_putFileAs(){

        $name = Str::random(10) . ".jpeg";
        $path = now();
        $image = UploadedFile::fake()->image($name);
        $res = $this->store->putFileAs($path,$image,$name);

        dump($res);
        $this->store->assertExists($path . "/" . $name);
        return $res;
    }

    /**
    * @test
    */
    public function fileMeta_can_be_got_by_the_result_of_putFileAs_method(){
        $path = $this->see_the_result_of_putFileAs();

        dd($this->store->getMetadata($path));
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
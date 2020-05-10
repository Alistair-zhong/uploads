<?php
namespace niro\Uploads\Tests\Unit;

use Orchestra\Testbench\TestCase;
use niro\Uploads\UploadBaseServiceProvider;

class TypeCheckerTest extends TestCase {

    /**
    * @test
    */
    public function img_type_can_be_checked(){
        $ext = 'jpG';
        $TypeChecker = app('TypeChecker');

        $this->assertSame('image',$TypeChecker->getType($ext));
    }
    /**
    * @test
    */
    public function other_type_can_be_checked(){
        $ext = 'fhh';
        $TypeChecker = app('TypeChecker');

        $this->assertSame('others',$TypeChecker->getType($ext));
    }


   
    public function getPackageProviders($app){
        return [
            UploadBaseServiceProvider::class,
        ];
    }
}

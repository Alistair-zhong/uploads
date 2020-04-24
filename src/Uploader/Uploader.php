<?php 
namespace niro\Uploads\Uploader;

use niro\Uploads\Jobs\GoogleUpload;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

/**
 * 负责文件的上传
 */
class Uploader {

    private $store;
    public $afterUpload;

    public function __construct(){
        $this->store = Storage::disk(config('uploads.default','google'));
    }
    
    /**
     * @param UploadedFile file  
     * @param string path
     */
    public function upload($file,$path = '',$hanlerName = null){
        $local = $this->store->putFileAs($path,$file,$file->getClientOriginalName());
    }

    /**
     * @param UploadedFile file  
     * @param string path
     */
    public function uploadInQueue($file,$path = '',$hanlerName = null){
        $local = Storage::putFileAs('',$file,$file->getClientOriginalName());
        $store_path = storage_path('app/'.$local);

        GoogleUpload::dispatch($store_path,$path,$hanlerName);
    }

    public function setHandleData(\Closure $afterUpload = null){
        $this->afterUpload = $afterUpload;
        $that = $this;
        app()->bindMethod(GoogleUpload::class.'@handle',function($job,$app)use($that){
            return $job->handle($that);
        });
    }

}
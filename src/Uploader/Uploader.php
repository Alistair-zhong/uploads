<?php 
namespace niro\uploads\Uploader;

/**
 * 负责文件的上传
 */
class Uploader {
    /**
     * @param UploadedFile file  
     * @param string path
     */
    public function upload($file,$path = ''){
        $local = Storage::putFileAs($path,$file,$file->getClientOriginalName());
        
        // $store_path = storage_path('app/'.$local);
        // GoogleUpload::dispatch($store_path);
    }
}
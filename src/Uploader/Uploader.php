<?php

namespace niro\Uploads\Uploader;

use niro\Uploads\Jobs\GoogleUpload;
use Illuminate\Support\Facades\Storage;

/**
 * 负责文件的上传.
 */
class Uploader
{
    private $store;
    public $afterUpload;

    public function __construct()
    {
        $this->store = Storage::disk(config('uploads.default'));
    }

    /**
     * @param UploadedFile file
     * @param string path
     * @param bool  useOldName 确定保存文件时是否使用原始的名字
     */
    public function upload($file, $path = '', $useOldName = true)
    {
        return $this->store->putFileAs($path, $file, $useOldName ? $file->getClientOriginalName() : random_name().'.'.$file->getClientOriginalExtension());
    }

    /**
     * @param UploadedFile file
     * @param string path
     */
    public function uploadInQueue($file, $path = '', $hanlerName = null)
    {
        $local = Storage::putFileAs('', $file, $file->getClientOriginalName());
        $store_path = storage_path('app/'.$local);

        GoogleUpload::dispatch($store_path, $path, $hanlerName);
    }
}

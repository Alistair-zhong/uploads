<?php

namespace niro\Uploads\Http\Controllers;

use Illuminate\Routing\Controller;
use niro\Uploads\Uploader\Uploader;
use niro\Uploads\Events\FileUploaded;
use niro\Uploads\Events\FileUploading;
use niro\Uploads\Http\Requests\UploadRequest;

class FileUploadController extends Controller
{
    protected $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploads(UploadRequest $request)
    {
        event(new FileUploading($request));

        $file = $request->file(config('uploads.input_name', 'upfile'));
        // file是返回来的文件信息数组
        $path = $this->uploader->upload($file, $request->path ?? '');

        $data = optional(event(new FileUploaded($path)))[0];

        return json_encode(['data' => $data]);
    }
}

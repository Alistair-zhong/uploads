<?php
namespace niro\Uploads\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use niro\Uploads\Uploader\Uploader;
use niro\Uploads\Events\FileUploaded;
use niro\Uploads\Events\FileUploading;

class GoogleDriveController extends Controller {
    
    protected $uploader;

    public function __construct(Uploader $uploader){
        $this->uploader = $uploader;
    }


    public function uploads(Request $request){
        event(new FileUploading($request));

        $file = $request->file(config('uploads.input_name','upfile'));
        // file是返回来的文件信息数组
        $path = $this->uploader->upload($file,$path ?? '');

        $id = event(new FileUploaded($path))[0];
        return json_encode(['id'=>$id]);

        // return redirect(route('google.upfile'));
    }

   /**
     * file 文件结构 为
     * 3 => array:10 [
     *      "name" => "tY6v4LwMHtxyyT334TiouGX3kKmMly8Tpd2cXoi4.jpeg"
     *      "type" => "file"
     *      "path" => "1Wbty0Sjg45n8hnzsaKJMI4RiH2foi99N"
     *      "filename" => "tY6v4LwMHtxyyT334TiouGX3kKmMly8Tpd2cXoi4"
     *      "extension" => "jpeg"
     *      "timestamp" => 1587310163
     *      "mimetype" => "image/jpeg"
     *      "size" => 6232
     *      "dirname" => ""
     *      "basename" => "1Wbty0Sjg45n8hnzsaKJMI4RiH2foi99N"
     * ]
     * 
     */
    
}
<?php
namespace niro\uploads\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GoogleDriveController extends Controller {
    
    protected $uploader;

    public function __construct(Uploader $uploader){
        $this->uploader = $uploader;
    }

    public function uploads(Request $request){
        $file = $request->file(config('uploads.input_name','upfile'));
        $this->uploader->upload($file,$path);
        
        return redirect(route('google.upfile'));
    }
}
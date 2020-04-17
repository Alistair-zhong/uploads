<?php

    Route::get('showimage',function(){
        $filename = 'pear.jpeg';
        $contents = collect(Storage::cloud()->listContents());

        $file = $contents->where('type','file')
                        ->where('filename',pathinfo($filename,PATHINFO_FILENAME))
                        ->where('extension',pathinfo($filename,PATHINFO_EXTENSION ))
                        ->first();
        return Storage::cloud()->url($file['path']);
        $rowData = Storage::cloud()->get($file['path']);
        // 创建一个文件
        $file = file_put_contents(storage_path('app/public/' . $filename),$rowData);

        $url = Storage::url($filename);
        return $url;
    })->name('show_image');

    Route::get('upfile',function(){
        return view('admin.test.googledrive');
    })->name('upfile');

    Route::post('store',function(Request $request){

        // $request->file('upfile')->store('','google');
        // $res = Storage::cloud()->put('/',$request->file('upfile'));
        // return $res;
        // ======= 使用队列的方式
        // 先存储到本地磁盘，然后在后台队列中将本地文件移动到google drive

        $local = $request->file('upfile')->storeAs('',$request->upfile->getClientOriginalName());
        $path = storage_path('app/'.$local);

        GoogleUpload::dispatch($path);
        return redirect(route('google.upfile'));
        
    })->name('store');

    Route::get('files','GoogleDriveCOntroller@files');

    Route::get('download','GoogleDriveController@download')->name('download');
    Route::get('delete','GoogleDriveController@deleteAll')->name('delete_all');

    Route::get('put', function() {
        Storage::cloud()->put('test.txt', 'Hello World bwefag');
        return 'File was saved to Google Drive';
    });

    Route::get('put-existing', function() {
        $filename = 'laravel.png';
        $filePath = public_path($filename);
        $fileData = File::get($filePath);
    
        Storage::cloud()->put($filename, $fileData);
        return 'File was saved to Google Drive';
    });


    Route::get('put-get-stream', function() {
        // Use a stream to upload and download larger files
        // to avoid exceeding PHP's memory limit.
    
        // Thanks to @Arman8852's comment:
        // https://github.com/ivanvermeyen/laravel-google-drive-demo/issues/4#issuecomment-331625531
        // And this excellent explanation from Freek Van der Herten:
        // https://murze.be/2015/07/upload-large-files-to-s3-using-laravel-5/
    
        // Assume this is a large file...
        $filename = 'video.webm';
        // $filePath = public_path($filename);
    
        // // Upload using a stream...
        // Storage::cloud()->put($filename, fopen($filePath, 'r+'));
    
        // Get file listing...
        $dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));
    
        // Get file details...
        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first(); // there can be duplicate file names!
    
        //return $file; // array with file info
    
        // Store the file locally...
        //$readStream = Storage::cloud()->getDriver()->readStream($file['path']);
        //$targetFile = storage_path("downloaded-{$filename}");
        //file_put_contents($targetFile, stream_get_contents($readStream), FILE_APPEND);
    
        // Stream the file to the browser...
        $readStream = Storage::cloud()->readStream($file['path']);
    
        return response()->stream(function () use ($readStream) {
            fpassthru($readStream);
        }, 200, [
            'Content-Type' => $file['mimetype'],
            //'Content-disposition' => 'attachment; filename="'.$filename.'"', // force download?
        ]);
    });

    // 上传文件
    Route::post('uploads','GoogleDriveController@uploads')->name('uploads');


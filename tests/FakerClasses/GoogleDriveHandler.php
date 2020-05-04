<?php
namespace niro\Uploads\Tests\FakerClasses;

use niro\Uploads\Contracts\HandleDataContract;

class GoogleDriveHandler implements HandleDataContract {
    
    public function HandleData($fileMeta){
            // 保存文件的元信息到数据库中
            $data = parseFileData($fileMeta);
            // File::create($data);
    }
}
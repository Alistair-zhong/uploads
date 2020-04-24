<?php
namespace niro\Uploads\Contracts;

interface HandleDataContract {
    /**
     * 用于文件上传之后处理数据，如保存到数据库
     * @param array fileMeta 文件的元数据数组   此参数在worker中自动传递
     */
    public function handleData($fileMeta);
}
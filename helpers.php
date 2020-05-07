<?php

if( ! function_exists('getUploadDisk') ){
    /**
     * 获取配置文件中的存储磁盘名称，如果没有就是用public
     */
    function getUploadDisk(){
        return config('uploads.default','public');
    }
}
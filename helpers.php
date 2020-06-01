<?php

if (!function_exists('getUploadDisk')) {
    /**
     * 获取配置文件中的存储磁盘名称，如果没有就是用public.
     */
    function getUploadDisk()
    {
        return config('uploads.default', 'public');
    }
}

if (!function_exists('random_name')) {
    /**
     * 随机生成文件的名字.
     * 结构为  12 位长的随机字符串 + "_" + 时间戳.
     *
     * @param int strlen 控制随机字符串的长度
     *
     * @return string
     */
    function random_name($strlen = 12)
    {
        return Str::random($strlen).'_'.now()->get('timestamp');
    }
}

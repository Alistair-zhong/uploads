<?php

return [
    /**
     * 指定默认存储磁盘   
     * 注意 :
     * 在此填写的必须在config/filesystem.php文件中已配置
     */
    'default'       => 'google',

    /**
     * 上传文件的名字，即表单input中的name属性值
     */
    'input_name'    => 'upfile',

    /**
     * 临时存放目录
     * 因为我们使用队列异步上传文件，而UploadFiled对象是无法被序列化的，所以我们需要先把文件存到服务器的临时文件夹,等队列执行结束后删除临时文件 
     */
    'tempory_dir'   => '',
];
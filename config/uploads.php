<?php

return [
    /**
     * 指定默认存储磁盘   
     * 注意 :
     * 在此填写的必须在config/filesystem.php文件中已配置或者在接下来的disk中配置
     */
    'default'       => 'public',

    /**
     * 此处是配置config/filesystem文件中的disks中的存储磁盘
     * 最终‘default’和‘default_disk’的配置会合并到config/filesystem文件中
     */
    'default_disk'    => [
        "driver"        => '',
        "clientId"      => '',
        "clientSecret"  => '',
        "refreshToken"  => '',
        "folderId"      => '',
        "folder"      => '',
    ],
    /**
     * 上传文件的名字，即表单input中的name属性值
     */
    'input_name'    => 'upfile',

    /**
     * 上传文件的最大size   单位kb
     */
    'max_size'   => '50000',

    /**
     * formRequest的验证规则,可在这里重写验证规则
     */
    'rule'  => [

    ],

    /**
     * 实现自定义formRequest类   需要时再做，实现接口绑定即可
     * 如果上面自定义规则不能满足你，那么可以直接重写验证类
     * 在此处填写你重写的验证类的全路径
     */
    'UploadRequest' => 'niro\Uploads\Http\Requests\UploadRequest'
];
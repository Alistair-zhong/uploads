## 文件上传

### Installation

    方式一：composer require niro/uploads

### Config

使用`php artisan vendor:publish --tag=uploads-config`会发布uploads配置文件和UploadServiceProvider自定义服务提供者。在uploads配置文件中需要指定存储的磁盘，默认是public，然后也可以在`default_disk`中配置相关的disk信息。配置文件中的`default、default_disk`会自动合并到filesystem的配置中。
如果用户使用的存储磁盘是google，那么可以使用`php artisan vendor:publish --tag=uploads-google`,会生成google drive已经定义好的的配置文件，控制器和视图。记得修改uploads里的存储磁盘配置或者config/fileysystem.php配置文件。

### Usage

#### upload 文件上传

1. 默认提供了上传的路由，`route("fileupload.uploads")`

2. 上传主要通过`niro\Uploads\Uploader\Uploader`这个类进行处理，调用其中的upload方法即可，该方法有三个参数，分别是path，file，useOldName。path指定用户保存在磁盘上的路径，file是用户上传的文件对象，类型是UploadedFile。useOldName是bool类型，默认值为true。如果为真，那么使用用户上传时的文件名字，否则随机生成hash名字。

3. 文件上传过程中的数据处理。如果用户想自定义做一些数据保存，我们提供了两个事件，分别是FileUploading、FileUploaded，代表文件上传前和文件上传后。FileUploading事件中传入request对象，作为其中的一个属性。FileUploaded事件传入上传文件的保存路径作为一个其中的一个属性。

```php
    -----FileUploading 提供的方法
    public function disk():string
    {
        return $this->disk;
    }

    public function path():string
    {
        return $this->path;
    }

    public function fileMeta():array
    {
        return array_map(function ($file) {
            return [
                'name'      => $file->getClientOriginalName(),
                'path'      => $this->path.'/'.$file->getClientOriginalName(),
                'extension' => $file->extension(),
            ];
        }, $this->files);
    }


    public function disk():string
    {
        return $this->store;
    }

    public function path():string
    {
        return $this->path;
    }

    /**
     * 根据文件的名字和路径获取文件信息
     * @return array
     */
    public function fileMeta():array
    {
        return $this->metaData;
    }
```

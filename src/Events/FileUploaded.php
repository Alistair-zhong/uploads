<?php 
namespace niro\Uploads\Events;

use Illuminate\Support\Facades\Storage;

class FileUploaded {
    /**
     * @var string
     */
    private $store;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $metaData;

    /**
     * @var string|null
     */
    private $overwrite;

    /**
     * FilesUploaded constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->store = Storage::disk(config('uploads.default','google'));
        $this->path = $path;
        $this->metaData = $this->store->getMetadata($path);
    }

    /**
     * @return string
     */
    public function disk():string
    {
        return $this->store;
    }

    /**
     * @return string
     */
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

    /**
     * @return bool
     */
    public function overwrite()
    {
        return !!$this->overwrite;
    }
}
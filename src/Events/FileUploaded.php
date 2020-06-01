<?php

namespace niro\Uploads\Events;

use Illuminate\Support\Facades\Storage;

class FileUploaded
{
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
     * @param string path
     * @param string origin_name
     */
    public function __construct(string $path, string $origin_name = '')
    {
        $this->store = Storage::disk(config('uploads.default'));
        $this->path = $path;
        $this->metaData = $this->store->getMetadata($path);

        if ($origin_name) {
            $this->metaData['origin_name'] = $origin_name;
        }
    }

    /**
     * @return string
     */
    public function disk(): string
    {
        return $this->store;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * 根据文件的名字和路径获取文件信息.
     *
     * @return array
     */
    public function fileMeta(): array
    {
        return $this->metaData;
    }

    /**
     * @return bool
     */
    public function overwrite()
    {
        return (bool) $this->overwrite;
    }
}

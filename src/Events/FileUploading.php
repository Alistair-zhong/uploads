<?php

namespace niro\Uploads\Events;

use Illuminate\Http\Request;

class FileUploading
{
    /**
     * @var string
     */
    private $disk;

    /**
     * @var string
     */
    private $path;

    /**
     * @var \Illuminate\Http\UploadedFile
     */
    private $files;

    /**
     * @var string|null
     */
    private $overwrite;

    /**
     * FilesUploading constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->disk = $request->input('disk');
        $this->path = $request->input('path');
        $this->files = $request->file('files');
        $this->overwrite = $request->input('overwrite');
    }

    /**
     * @return string
     */
    public function disk(): string
    {
        return $this->disk;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function fileMeta(): array
    {
        return array_map(function ($file) {
            return [
                'name' => $file->getClientOriginalName(),
                'path' => $this->path.'/'.$file->getClientOriginalName(),
                'extension' => $file->extension(),
            ];
        }, $this->files);
    }

    /**
     * @return bool
     */
    public function overwrite()
    {
        return (bool) $this->overwrite;
    }
}

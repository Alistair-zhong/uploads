<?php

namespace niro\Uploads\Jobs;

use Illuminate\Http\File;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GoogleUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $path;
    protected $handlerName;

    /**
     * Create a new job instance.
     *
     * @param string file文件的全路径名称
     * @param string 将要保存到的磁盘路径
     */
    public function __construct($file, $path = '/', $handlerName = null)
    {
        $this->file = $file;
        $this->path = $path;
        $this->disk = config('uploads.default');
        $this->handlerName = $handlerName;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $file = new File($this->file);
        $filename = Storage::disk(config('uploads.default'))->put($this->path, $file);
        $fileMeta = $this->getFileByName($filename);

        // TODO 使用事件机制处理数据

        Storage::delete(basename($this->file));
    }

    public function getFileByName($filename)
    {
        $contents = collect(Storage::disk(config('uploads.default'))->listContents($this->path));

        return $contents->where('type', 'file')
                        ->where('filename', pathinfo($filename, PATHINFO_FILENAME))
                        ->where('extension', pathinfo($filename, PATHINFO_EXTENSION))
                        ->first();
    }
}

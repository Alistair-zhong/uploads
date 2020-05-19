<?php

namespace niro\Uploads;

class TypeChecker
{
    /**
     * 图片扩展名集合.
     */
    private $img_ext = ['jpeg', 'jpg', 'gif', 'png', 'eps', 'ai', 'pdf', 'psd', 'webp'];

    /**
     * 视频扩展名集合.
     */
    private $video_ext = ['webm', 'mp4', 'wmv', 'flv', 'avi', 'quicktime', 'mov'];

    /**
     * 文本的扩展名集合.
     */
    private $word_ext = ['txt', 'md', 'doc', 'docx', 'xlsx', 'pub'];

    /**
     * 音频的扩展名集合.
     */
    private $audio_ext = ['mp3', 'wav', 'vox', 'voc'];

    /**
     * 其他扩展名.
     */
    private $others_ext = [];

    /**
     * 传入扩展名，返回文件类型,已知类型是图片、视频、文本、音频，除此之外都算其他类型.
     *
     * @param string ext 扩展名字符串
     */
    public function getType(string $ext): string
    {
        $ext = strtolower($ext);

        if ($this->isImg($ext)) {
            return 'image';
        }

        if ($this->isVideo($ext)) {
            return 'video';
        }

        if ($this->isWord($ext)) {
            return 'word';
        }

        if ($this->isAudio($ext)) {
            return 'audio';
        }

        return 'others';
    }

    /**
     * @param ext 扩展名字符串
     *
     * @return bool
     */
    public function isImg(string $ext): bool
    {
        return in_array($ext, $this->img_ext);
    }

    /**
     * @param ext 扩展名字符串
     *
     * @return bool
     */
    public function isVideo(string $ext): bool
    {
        return in_array($ext, $this->video_ext);
    }

    /**
     * @param ext 扩展名字符串
     *
     * @return bool
     */
    public function isWord(string $ext): bool
    {
        return in_array($ext, $this->word_ext);
    }

    /**
     * @param ext 扩展名字符串
     *
     * @return bool
     */
    public function isAudio(string $ext): bool
    {
        return in_array($ext, $this->audio_ext);
    }

    public function getImgExt()
    {
        return $this->img_ext;
    }

    public function getVideoExt()
    {
        return $this->video_ext;
    }

    public function getWordExt()
    {
        return $this->word_ext;
    }

    public function getaudioType()
    {
        return $this->audio_ext;
    }
}

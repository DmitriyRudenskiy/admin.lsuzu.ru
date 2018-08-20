<?php

namespace App\Tools;

class ImagePath
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $hash;

    const SIZE_FULL = 'full';
    const SIZE_THUMBNAIL = 'thumbnail';
    const EXTENSION = '.jpg';

    /**
     * ImagePath constructor.
     * @param string $hash
     */
    public function __construct($hash)
    {
        $this->hash = $hash;

        $this->path = DIRECTORY_SEPARATOR
            . substr($hash, 0, 2)
            . DIRECTORY_SEPARATOR
            . substr($hash, 2, 2);
    }

    public function getPathFullSize()
    {
        $dir = storage_path('image')
            . DIRECTORY_SEPARATOR
            . self::SIZE_FULL
            . $this->path;


        $file = $dir
            . DIRECTORY_SEPARATOR
            . substr($this->hash, 4, 28)
            . self::EXTENSION;

        return $file;
    }

    public function getPathThumbnailSize()
    {
        $dir = storage_path('image')
            . DIRECTORY_SEPARATOR
            . self::SIZE_THUMBNAIL
            . $this->path;


        $file = $dir
            . DIRECTORY_SEPARATOR
            . substr($this->hash, 4, 28)
            . self::EXTENSION;

        return $file;
    }
}
<?php
namespace App\Console;

use App\Models\Image;
use App\Tools\ImagePath;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class CheckDownloadImages extends Command
{
    const MARKER_NOT_FIND = 0;
    const MARKER_DOWNLOAD = 1;
    const MARKER_CLEAR = 2;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:download:images';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepareImage();

        $this->check();
    }

    /**
     *
     */
    protected function prepareImage()
    {
        $isNew = Image::where('download', self::MARKER_CLEAR)
            ->where('')
            ->first();

        // остались в очереди на проверку
        if ($isNew === null) {
            Image::where('id', '>', 0)->update(['download' => self::MARKER_CLEAR]);
        }
    }

    /**
     *
     */
    protected function check()
    {
        $work = true;

        do {
            $list = Image::where('download', self::MARKER_CLEAR)
                ->orderBy('id')
                ->limit(50)
                ->get();

            if ($list->count() > 0) {
                $this->readList($list);
            } else {
                $work = false;
            }
        } while ($work);
    }

    /**
     * @param Collection $list
     */
    protected function readList(Collection $list)
    {
        foreach ($list as $value) {
            $this->update($value);
        }
    }

    /**
     * @param Image $image
     */
    protected function update(Image $image)
    {
        $image->download = self::MARKER_DOWNLOAD;

        $imagePath = new ImagePath($image->hash);

        if (!file_exists($imagePath->getPathFullSize())
            || !file_exists($imagePath->getPathThumbnailSize())) {
            $image->download = self::MARKER_NOT_FIND;
        }

        $image->save();
    }
}


<?php
namespace App\Console;

use App\Models\Image;
use App\Models\QueryImage;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Illuminate\Console\Command;

class ImportListImageFromFiles extends Command
{
    const VENDOR_GOOGLE = 1;
    const VENDOR_YANDEX = 3;

    /**
     * @var int
     */
    private $vendorId = 0;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:image:from:files';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        $vendorList = [
            self::VENDOR_GOOGLE => storage_path('import/google'),
            self::VENDOR_YANDEX => storage_path('import/yandex')
        ];

        foreach ($vendorList as $key => $value) {
            // где брали картинку
            $this->vendorId = $key;

            // загружаем контент
            $this->loadFiles($value);
        }
    }

    protected function loadFiles($path)
    {
        if (!is_dir($path)) {
            return;
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach($files as $value){
            $this->check($value);
        }
    }

    /**
     * @param \SplFileInfo $fileInfo
     * @return bool
     */
    protected function check(\SplFileInfo $fileInfo)
    {
        if ($fileInfo->getFilename() == "." || $fileInfo->getFilename() == "..") {
            return false;
        }

        $queryId = (int)(explode(".", $fileInfo->getFilename())[0]);

        $this->readFile($fileInfo->getPathname(), $queryId);

        // delete files
        unlink($fileInfo->getPathname());

        return true;
    }

    /**
     * @param $path
     */
    protected function readFile($path, $queryId)
    {
        $content = $this->getContent($path);

        $list = explode("\n", $content);

        $this->info(sprintf("Find %d from %d", sizeof($list), $queryId));

        foreach ($list as $value) {
            $this->mapper($value, $queryId);
        }
    }

    /**
     * @param string $path
     * @return string
     */
    protected function getContent($path)
    {
        $content = file_get_contents($path);

        // не правельная кодировка файла
        if (strpos($content, 'и') === false) {
            $content = mb_convert_encoding($content, "utf-8", "windows-1251");
        }

        $content = str_replace("}{", "}\n{", $content);

        return $content;
    }

    protected function mapper($string, $queryId)
    {
        $json = json_decode($string);

        // не корректный url
        if (empty($json->url)) {
            return null;
        }

        $hash = md5($json->url);

        $modelImage = new Image();

        // если существует значит загружена
        if ($modelImage->has($hash)) {
            $image = $modelImage->get($hash);
        } else {
            // сохраняем картинку
            try {
                $this->saveImage($json->url, $hash);
            } catch (\Exception $e) {
                $this->error('Eroro url: ' . $json->url);
                return null;
            }

            // записываем в базу данных
            $data = [
                'vendor_id' => $this->vendorId,
                'hash' => $hash,
                'title' => $this->clearText($json->title),
                'description' => $json->text,
                'original' => $json->url,
                'source' => $json->dub
            ];

            $image = $modelImage->add($data);
        }

        $this->info(sprintf("Add image: %d for query %d", $image->id, $queryId));

        QueryImage::add($queryId, $image->id);
    }

    protected function clearText($text)
    {
        $text = str_replace('...', '', $text);
        $text = trim($text);

        return $text;
    }

    /**
     * @param $url
     * @param $hash
     * @return null
     */
    protected function saveImage($url, $hash)
    {
        $baseImageDir = realpath(__DIR__ . '/../../../../lsuzu.ru/public/image');

        $path = DIRECTORY_SEPARATOR
            . substr($hash, 0, 2)
            . DIRECTORY_SEPARATOR
            . substr($hash, 2, 2);

        $imagine = new Imagine();

        $dir =  $baseImageDir . DIRECTORY_SEPARATOR . 'full' . $path;


        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file = $dir . DIRECTORY_SEPARATOR . substr($hash, 4, 28) . '.jpg';

        // файл уже существует
        if (file_exists($file)) {
            return null;
        }

        $content = @file_get_contents($url);

        // не удалось загрузить картинку
        if (empty($content)) {
            return null;
        }

        $image = @imagecreatefromstring($content);

        // не удалось загрузить картинку
        if ($image === false) {
            return null;
        }

        // сохраняем изображение
        $imagine->load($content)
            ->resize(new Box(800, 600))
            ->save($file, ['jpeg_quality' => 85]);

        $dir = $baseImageDir . DIRECTORY_SEPARATOR . 'thumbnail' . $path;

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file = $dir . DIRECTORY_SEPARATOR . substr($hash, 4, 28) . '.jpg';

        // файл уже существует
        if (!file_exists($file)) {
            // сохраняем обложку
            $imagine->load($content)
                ->thumbnail(new Box(360, 270), ImageInterface::THUMBNAIL_INSET)
                ->save($file, ['jpeg_quality' => 85]);
        }
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use App\Models\Query;
use App\Models\QueryImage;
use App\Tools\ImagePath;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageController extends Controller
{
    public function edit($queryId, $imageId, Image $imageRepository)
    {
        $imageEntity = $imageRepository->findOrFail($imageId);

        return view(
            'admin.image.view',
            [
                'image' => $imageEntity,
                'query_id' => $queryId
            ]
        );
    }


    public function update(Request $request, Query $queryRepository, Image $imageRepository)
    {
        $id = $request->get('id');
        $data = $request->only(['title', 'description', 'original']);

        $imageEntity = $imageRepository->findOrFail($id);
        $imageEntity->update($data);

        return redirect()
            ->route('admin_query_view', ['id' => $request->get('query_id')])
            ->with('success', 1);
    }

    public function delete($id)
    {

    }

    public function upload(Request $request, Query $queryRepository, Image $imageRepository)
    {
        $baseImageDir = realpath(app_path() . DIRECTORY_SEPARATOR . env('IMAGE_PATH'));

        if (!$baseImageDir) {
            throw new \RuntimeException();
        }


        if (!$request->hasFile('file')) {
            dd('File not load');
        }

        $query = $queryRepository->findOrFail($request->get('query_id'));

        $image = $request->file('file');
        $hash = md5(time() . DIRECTORY_SEPARATOR . $image->getClientOriginalName());


        $path = DIRECTORY_SEPARATOR
            . substr($hash, 0, 2)
            . DIRECTORY_SEPARATOR
            . substr($hash, 2, 2);

        $imagine = new Imagine();

        $dir = $baseImageDir . DIRECTORY_SEPARATOR . 'full' . $path;


        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file = $dir . DIRECTORY_SEPARATOR . substr($hash, 4, 28) . '.jpg';

        // файл уже существует
        if (file_exists($file)) {
            return null;
        }

        // сохраняем изображение
        $imagine->open($image->getRealPath())
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
            $imagine->open($image->getRealPath())
                ->thumbnail(new Box(360, 270), ImageInterface::THUMBNAIL_INSET)
                ->save($file, ['jpeg_quality' => 85]);
        }

        // сохраняем в базу данных
        $data = [
            'vendor_id' => 3,
            'hash' => $hash,
            'title' => '',
            'description' => '',
            'original' => '',
            'source' => ''
        ];
        $imageEntity = $imageRepository->add($data);

        QueryImage::add($query->id, $imageEntity->id);

        return redirect()
            ->route('admin_image_edit', ['queryId' => $query->id, 'imageId' => $imageEntity->id])
            ->with('success', 1);
    }
}
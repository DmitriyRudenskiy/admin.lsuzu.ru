<?php

namespace App\Http\Controllers\Admin;

use App\Models\Query;
use App\Tools\ImagePath;
use App\Tools\Translit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QueryController extends Controller
{
    public function index(Query $queryRepository)
    {
        $list = $queryRepository->orderBy('id', 'desc')->paginate(15);

        return view(
            'admin.query.index',
            [
                'list' => $list
            ]
        );
    }

    public function view($id, Query $queryRepository)
    {
        $query = $queryRepository->findOrFail($id);

        return view(
            'admin.query.view',
            [
                'query' => $query,
                'images' => $query->images()->orderBy('id', 'desc')->paginate(12)
            ]
        );
    }

    public function insert(Request $request, Query $queryRepository)
    {
        $query = new $queryRepository;
        $query->visible = 1;
        $query->name = trim($request->get('query'));
        $query->alias = (new Translit())->get($query->name);
        $query->save();

        return redirect()->back();
    }

    public function image($hash)
    {
        $image = (new ImagePath($hash))->getPathThumbnailSize();

        if (!file_exists($image)) {
            throw new NotFoundHttpException();
        }

        header("Content-type: image/jpeg");
        echo file_get_contents($image);
    }
}
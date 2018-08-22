<?php

namespace App\Http\Controllers\Admin;

use App\Models\Query;
use App\Tools\ImagePath;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageController extends Controller
{
    public function add()
    {

    }

    public function edit($id, Query $queryRepository)
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


    public function update($id, Query $queryRepository)
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

    public function delete($id)
    {

    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Query;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QueryController extends Controller
{
    public function index(Query $queryRepository)
    {
        $list = $queryRepository->paginate(15);

        return view(
            'admin.query.index',
            [
                'list' => $list
            ]
        );
    }

    public function view($id, Query $queryRepository)
    {
        $list = $queryRepository->paginate(15);

        return view(
            'admin.query.index',
            [
                'list' => $list
            ]
        );
    }
}
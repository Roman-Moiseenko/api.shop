<?php

namespace App\Modules\Base\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Request\BreadCrumbsRequest;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;

class BreadcrumbsController extends Controller
{
    public function index(BreadCrumbsRequest $request)
    {

        $data = Breadcrumbs::render('product.category.index');
        \Log::info(json_encode($data));
        return \response()->json($data);
    }
}

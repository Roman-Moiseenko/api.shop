<?php

namespace App\Modules\Base\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Request\BreadCrumbsRequest;
use App\Modules\Product\Entity\Brand;
use App\Modules\Product\Entity\Category;
use App\Modules\Product\Entity\Product;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BreadcrumbsController extends Controller
{
    public function index(BreadCrumbsRequest $request): \Illuminate\Http\JsonResponse
    {
        $route_name = $request->string('route')->value();
        $route = app('router')->getRoutes()->match(app('request')->create($route_name));
        $parameters = [];
        foreach ($route->parameters() as $key => $value) {

                $parameters[] = $this->resolveEloquentModel($key, $value);
        }
        $data = Breadcrumbs::view('breadcrumbs::json-ld', $route->getName(), ...$parameters)->getData()['breadcrumbs'];

        $breadcrumbs = [];
        foreach($data as $item) {
            $breadcrumbs[] = [
                'label' => $item->title,
                'to' => $item->url
            ];
        }
     //   \Log::info(json_encode($data));
        return \response()->json($breadcrumbs);
    }

    function resolveEloquentModel(string $parameterName, $parameterValue): ?Model
    {
        $modelParameterMap = [
            'category' => Category::class,
            'product' => Product::class,
            'brand' => Brand::class,



            // Добавьте другие соответствия


        ];

        /** @var Model $modelClass */
        $modelClass = $modelParameterMap[$parameterName] ?? null;
        if (!is_null($modelClass))
            return $modelClass::find((int)$parameterValue);

        return null;
    }
}

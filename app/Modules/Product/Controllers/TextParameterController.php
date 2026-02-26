<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\TextParameter;
use App\Modules\Product\Request\TextParameterRequest;
use Illuminate\Http\Request;

class TextParameterController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(Request $request)
    {
        \Log::info(json_encode($request->header()));
        return TextParameter::orderBy('name')->get()->toArray();
    }

    public function show(TextParameter $parameter): array
    {
        return $parameter->toArray();
    }

    public function create(TextParameterRequest $request): \Illuminate\Http\JsonResponse
    {
        $parameter = TextParameter::register(
            $request->string('name')->trim()->value(),
            $request->string('slug')->trim()->value()
        );

        $parameter->fill($request->all())->save();
        return \response()->json(true);
    }

    public function update(TextParameter $parameter, TextParameterRequest $request): \Illuminate\Http\JsonResponse
    {
        $parameter->fill($request->all())->save();
        return \response()->json(true);
    }

    public function destroy(TextParameter $parameter): \Illuminate\Http\JsonResponse
    {
        $parameter->delete();
        return \response()->json(true);
    }

}

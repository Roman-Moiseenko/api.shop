<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\TextParameter;
use App\Modules\Product\Request\TextParameterRequest;
use Illuminate\Http\Request;

class TextParameterController extends Controller
{
   // private TextParameterService $service;


    public function __construct()
    {
        $this->middleware(['auth:api']);
      //  $this->service = $service;
    }


    public function index()
    {
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
        /*
        $text_parameter->name = $request->string('name')->trim()->value();
        $text_parameter->slug = $request->string('slug')->trim()->value();
        $text_parameter->description = $request->string('description')->trim()->value();
        $text_parameter->is_category = $request->boolean('is_category');
        $text_parameter->is_product = $request->boolean('is_product');
        $text_parameter->is_group = $request->boolean('is_group');
        $text_parameter->save();*/

        return \response()->json(true);
    }

    public function destroy(TextParameter $text_parameter)
    {
        $text_parameter->delete();
        return \response()->json(true);
    }

}

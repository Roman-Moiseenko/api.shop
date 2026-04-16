<?php

use App\Modules\Product\Controllers\AttributeController;
use App\Modules\Product\Controllers\BrandController;
use App\Modules\Product\Controllers\CategoryController;
use App\Modules\Product\Controllers\ProductController;
use App\Modules\Product\Controllers\ProductsController;
use App\Modules\Product\Controllers\TextParameterController;

Route::group(
    [
        'prefix' => 'products',
        'as' => 'products.',
    ], function () {

        Route::group([
            'prefix' => 'product',
            'as' => 'product.',
        ], function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
        });

        Route::group([
            'prefix' => 'parameter',
            'as' => 'parameter.',
        ], function () {
            Route::get('/{parameter}', [TextParameterController::class, 'show'])->name('show');
            Route::get('/', [TextParameterController::class, 'index'])->name('index');
            Route::post('/', [TextParameterController::class, 'create'])->name('create');
            Route::post('/{parameter}', [TextParameterController::class, 'update'])->name('update');
            Route::delete('/{parameter}', [TextParameterController::class, 'destroy'])->name('destroy');
        });

        Route::group([
            'prefix' => 'brand',
            'as' => 'brand.',
        ], function () {
            Route::get('/', [BrandController::class, 'index'])->name('index');
        });

        // CATEGORY
        Route::group([
            'prefix' => 'category',
            'as' => 'category.',
        ], function () {
            Route::get('/last-modified', [CategoryController::class, 'last_modified']);
            Route::post('/up/{category}', [CategoryController::class, 'up'])->name('up');
            Route::post('/down/{category}', [CategoryController::class, 'down'])->name('down');
            //    Route::get('/child/{category}', [CategoryController::class, 'child'])->name('child');
            Route::get('/list', [CategoryController::class, 'list'])->name('list');
            Route::post('/set-info/{category}', [CategoryController::class, 'set_info'])->name('set-info');
            Route::post('/set-image/{category}', [CategoryController::class, 'set_image'])->name('set-image');

            Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
            Route::get('/children/{category}', [CategoryController::class, 'get_children'])->name('get-children');
            Route::get('/attributes/{category}', [CategoryController::class, 'get_attributes'])->name('get-attributes');
            Route::get('/products/{category}', [CategoryController::class, 'get_products'])->name('get-products');

            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('/', [CategoryController::class, 'create'])->name('create');
        });

        // ATTRIBUTES
        Route::group([
            'prefix' => 'attribute',
            'as' => 'attribute.',
        ], function () {
            // Доп. - сменить категорию, добавить фото
            Route::get('/groups', [AttributeController::class, 'groups'])->name('groups');
            Route::delete('/group/{group}', [AttributeController::class, 'group_destroy'])->name('group-destroy');
            Route::get('/guide', [AttributeController::class, 'guide'])->name('guide');



            Route::post('/group-create', [AttributeController::class, 'group_create'])->name('group-add');
            Route::post('/group-rename/{group}', [AttributeController::class, 'group_rename'])->name('group-rename');
            // Route::post('/variant-image/{variant}', [AttributeController::class, 'variant_image'])->name('variant-image');

            Route::post('/group-up/{group}', [AttributeController::class, 'group_up'])->name('group-up');
            Route::post('/set-info/{attribute}', [AttributeController::class, 'set_info'])->name('set-info');

            Route::post('/group-down/{group}', [AttributeController::class, 'group_down'])->name('group-down');

            Route::delete('/{attribute}', [AttributeController::class, 'destroy'])->name('destroy');
            Route::get('/{attribute}', [AttributeController::class, 'show'])->name('index');
            Route::get('/', [AttributeController::class, 'index'])->name('index');
            Route::post('/', [AttributeController::class, 'create'])->name('create');
        });

        Route::get('/', [ProductsController::class, 'index'])->name('index');
        // Route::resource('category', 'CategoryController'); //CRUD
    })->middleware(['auth:api']);

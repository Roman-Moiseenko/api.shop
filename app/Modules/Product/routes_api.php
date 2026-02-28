<?php

use App\Modules\Product\Controllers\BrandController;
use App\Modules\Product\Controllers\CategoryController;
use App\Modules\Product\Controllers\TextParameterController;


Route::group(
    [
        'prefix' => 'products',
        'as' => 'products.',
    ], function () {

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


    //CATEGORY
    Route::group([
        'prefix' => 'category',
        'as' => 'category.',
    ], function () {
        Route::post('/up/{category}', [CategoryController::class, 'up'])->name('up');
        Route::post('/down/{category}', [CategoryController::class, 'down'])->name('down');
        //    Route::get('/child/{category}', [CategoryController::class, 'child'])->name('child');
        Route::get('/list', [CategoryController::class, 'list'])->name('list');
        Route::post('/set-info/{category}', [CategoryController::class, 'set_info'])->name('set-info');

        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/', [CategoryController::class, 'create'])->name('create');
    });

   // Route::resource('category', 'CategoryController'); //CRUD
})->middleware(["auth:api"]);

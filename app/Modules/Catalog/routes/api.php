<?php

// use Illuminate\Support\Facades\Route;

// Route::middleware([])->prefix('catalog')->group(function () {

//     Route::get('/api', function () {
//         return 'catalog';
//     });

// });

use App\Modules\Catalog\Presentation\Http\Controllers\CategoryController;

Route::prefix('v1/catalog')->group(function () {
    Route::apiResource('categories', CategoryController::class)->parameters([
        'categories' => 'slug',
    ])->except(['show']);
    Route::get('categories/{slug}', [CategoryController::class, 'show']);
});

<?php

use App\Modules\Product\Controllers\BrandController;

Route::get('/brands', [BrandController::class, 'index'])->name('brands');


<?php

use App\Modules\Base\Controllers\BreadcrumbsController;
use App\Modules\Base\Controllers\HomeController;
use App\Modules\Base\Controllers\LockController;

Route::group([
    'prefix' => 'lock',
    'as' => 'lock.',
], function () {
    Route::post('/set', [LockController::class, 'lock'])->name('set');
    Route::post('/remove', [LockController::class, 'unlock'])->name('remove');
    Route::post('/status', [LockController::class, 'status'])->name('status');
})->middleware(["auth:api"]);

Route::post('/breadcrumbs', [BreadcrumbsController::class, 'index'])->middleware(["auth:api"]);
Route::get('/dashboard', [HomeController::class, 'index'])->name('api.home')->middleware(["auth:api"]);

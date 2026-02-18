<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$modules_folder = app_path('Modules');
$modules = getModulesList($modules_folder);

foreach ($modules as $module) {
    $routesPath = $modules_folder . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'routes_api.php';

    if (file_exists($routesPath)) {
        Route::namespace("\\App\\Modules\\$module\Controllers")
            ->group($routesPath);
    }
}


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


function getModulesList(string $modules_folder): array
{
    return
        array_values(
            array_filter(
                scandir($modules_folder),
                function ($item) use ($modules_folder) {
                    return is_dir($modules_folder . DIRECTORY_SEPARATOR . $item) && !in_array($item, ['.', '..']);
                }
            )
        );
};







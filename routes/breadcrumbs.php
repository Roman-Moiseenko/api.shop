<?php
declare(strict_types=1);

use App\Modules\Product\Entity\Brand;
use App\Modules\Product\Entity\Product;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


modules_callback('breadcrumbs.php', function ($routesPath) {
    require $routesPath;
});



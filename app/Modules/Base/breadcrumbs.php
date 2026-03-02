<?php
declare(strict_types=1);

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
Breadcrumbs::for('api.home', function (BreadcrumbTrail $trail) {
    $trail->push('CRM', route('api.home', null, false));
});


Breadcrumbs::for('admin.settings.shop', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.home');
    $trail->push('Интернет Магазин', route('admin.settings.shop'));
});

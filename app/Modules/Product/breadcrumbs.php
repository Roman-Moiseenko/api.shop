<?php
declare(strict_types=1);

use App\Modules\Product\Entity\Brand;

use App\Modules\Product\Entity\Equivalent;
use App\Modules\Product\Entity\Group;
use App\Modules\Product\Entity\Modification;
use App\Modules\Product\Entity\Product;
use App\Modules\Product\Entity\Series;

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Modules\Product\Entity\Category;
use App\Modules\Product\Entity\Attribute;



Breadcrumbs::for('products.index', function (BreadcrumbTrail $trail) {
    $trail->parent('api.home');
    $trail->push('Магазин', route('products.index', null,false));
});

Breadcrumbs::for('products.parameter.index', function (BreadcrumbTrail $trail) {
    $trail->parent('products.index');
    $trail->push('Текстовые параметры', route('products.parameter.index', null,false));
});

Breadcrumbs::for('products.product.index', function (BreadcrumbTrail $trail) {
    $trail->parent('products.index');
    $trail->push('Товары', route('products.product.index', null,false));
});

Breadcrumbs::for('products.product.create', function (BreadcrumbTrail $trail) {
    $trail->parent('products.product.index');
    $trail->push('Добавить новый', route('products.product.create', null,false));
});
Breadcrumbs::for('products.product.show', function (BreadcrumbTrail $trail, Product $product) {
    $trail->parent('products.product.index');
    $trail->push($product->name, route('products.product.show', $product, false));
});
Breadcrumbs::for('products.product.edit', function (BreadcrumbTrail $trail, Product $product) {
    $trail->parent('products.product.show', $product);
    $trail->push('Редактировать', route('products.product.edit', $product, false));
});
Breadcrumbs::for('products.product.update', function (BreadcrumbTrail $trail, Product $product) {
    $trail->parent('products.product.index');
    $trail->push($product->name, route('products.product.show', $product, false));
});

//BRAND
Breadcrumbs::for('products.brand.index', function (BreadcrumbTrail $trail) {
    $trail->parent('products.index');
    $trail->push('Бренды', route('products.brand.index', null,false));
});

Breadcrumbs::for('products.brand.create', function (BreadcrumbTrail $trail) {
    $trail->parent('products.brand.index');
    $trail->push('Добавить новый', route('products.brand.create', null,false));
});
Breadcrumbs::for('products.brand.show', function (BreadcrumbTrail $trail, Brand $brand) {
    $trail->parent('products.brand.index');
    $trail->push($brand->name, route('products.brand.show', $brand, false));
});
Breadcrumbs::for('products.brand.edit', function (BreadcrumbTrail $trail, Brand $brand) {
    $trail->parent('products.brand.show', $brand);
    $trail->push('Редактировать', route('products.brand.edit', $brand, false));
});

//CATEGORY
Breadcrumbs::for('products.category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('products.index');
    $trail->push('Категории', route('products.category.index', null,false));
});
Breadcrumbs::for('products.category.create', function (BreadcrumbTrail $trail) {
    $trail->parent('products.category.index');
    $trail->push('Добавить категорию', route('products.category.create', null,false));
});
Breadcrumbs::for('products.category.child', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('products.category.show', $category);
    $trail->push('Добавить подкатегорию', route('products.category.create', null,false));
});
Breadcrumbs::for('products.category.show', function (BreadcrumbTrail $trail, Category $category) {
    if ($category->parent) {
        $trail->parent('products.category.show', $category->parent);
    } else {
        $trail->parent('products.category.index');
    }
    $trail->push($category->name, route('products.category.show', $category, false));
});

Breadcrumbs::for('products.category.edit', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('products.category.show', $category);
    $trail->push('Редактировать', route('products.category.edit', $category, false));
});
Breadcrumbs::for('products.category.update', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('products.category.index');
    $trail->push($category->name, route('products.category.show', $category, false));
});

//ATTRIBUTE
Breadcrumbs::for('admin.product.attribute.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.index');
    $trail->push('Атрибуты', route('admin.product.attribute.index'));
});
Breadcrumbs::for('admin.product.attribute.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.attribute.index');
    $trail->push('Добавить новый', route('admin.product.attribute.create'));
});
Breadcrumbs::for('admin.product.attribute.show', function (BreadcrumbTrail $trail, Attribute $attribute) {
    $trail->parent('admin.product.attribute.index');
    $trail->push($attribute->name, route('admin.product.attribute.show', $attribute));
});
Breadcrumbs::for('admin.product.attribute.edit', function (BreadcrumbTrail $trail, Attribute $attribute) {
    $trail->parent('admin.product.attribute.show', $attribute);
    $trail->push('Редактировать', route('admin.product.attribute.edit', $attribute));
});
Breadcrumbs::for('admin.product.attribute.update', function (BreadcrumbTrail $trail, Attribute $attribute) {
    $trail->parent('admin.product.attribute.index');
    $trail->push($attribute->name, route('admin.product.attribute.show', $attribute));
});

Breadcrumbs::for('admin.product.attribute.groups', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.attribute.index');
    $trail->push('Группы', route('admin.product.attribute.groups'));
});

//TAGS
Breadcrumbs::for('admin.product.tag.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.index');
    $trail->push('Метки (Теги)', route('admin.product.tag.index'));
});

//EQUIVALENT
Breadcrumbs::for('admin.product.equivalent.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.index');
    $trail->push('Аналоги', route('admin.product.equivalent.index'));
});
Breadcrumbs::for('admin.product.equivalent.show', function (BreadcrumbTrail $trail, Equivalent $equivalent) {
    $trail->parent('admin.product.equivalent.index');
    $trail->push($equivalent->name, route('admin.product.equivalent.show', $equivalent));
});

//GROUP
Breadcrumbs::for('admin.product.group.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.index');
    $trail->push('Группы', route('admin.product.group.index'));
});

Breadcrumbs::for('admin.product.group.show', function (BreadcrumbTrail $trail, Group $group) {
    $trail->parent('admin.product.group.index');
    $trail->push($group->name, route('admin.product.group.show', $group));
});
/*
Breadcrumbs::for('admin.product.group.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.group.index');
    $trail->push('Добавить новую', route('admin.product.group.create'));
});*/
/*
Breadcrumbs::for('admin.product.group.edit', function (BreadcrumbTrail $trail, Group $group) {
    $trail->parent('admin.product.group.show', $group);
    $trail->push('Редактировать', route('admin.product.group.edit', $group));
});*/

//MODIFICATION
Breadcrumbs::for('admin.product.modification.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.index');
    $trail->push('Модификации', route('admin.product.modification.index'));
});
Breadcrumbs::for('admin.product.modification.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.modification.index');
    $trail->push('Создать новую', route('admin.product.modification.create'));
});
Breadcrumbs::for('admin.product.modification.show', function (BreadcrumbTrail $trail, Modification $modification) {
    $trail->parent('admin.product.modification.index');
    $trail->push($modification->name, route('admin.product.modification.show', $modification));
});
Breadcrumbs::for('admin.product.modification.edit', function (BreadcrumbTrail $trail, Modification $modification) {
    $trail->parent('admin.product.modification.show', $modification);
    $trail->push('Редактировать', route('admin.product.modification.edit', $modification));
});


//SERIES
Breadcrumbs::for('admin.product.series.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.index');
    $trail->push('Серии товаров', route('admin.product.series.index'));
});
Breadcrumbs::for('admin.product.series.show', function (BreadcrumbTrail $trail, Series $series) {
    $trail->parent('admin.product.series.index');
    $trail->push($series->name, route('admin.product.series.show', $series));
});
//PRIORITY
Breadcrumbs::for('admin.product.priority.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.index');
    $trail->push('Приоритетный показ товаров', route('admin.product.priority.index'));
});
//REDUCED
Breadcrumbs::for('admin.product.reduced.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.index');
    $trail->push('Цена снижена на товар', route('admin.product.reduced.index'));
});
//ON-ORDER
Breadcrumbs::for('admin.product.on-order.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.index');
    $trail->push('Только под заказ', route('admin.product.on-order.index'));
});
//GROUP
Breadcrumbs::for('admin.product.size.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.product.index');
    $trail->push('Размеры', route('admin.product.size.index'));
});



<?php

namespace App\Console\Commands\StartCommand;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesCommand extends Command
{
    protected $signature = 'start:roles';
    protected $description = 'Создание основных ролей и доступов';

    public function handle(): bool
    {
        if (is_null(Role::findByName('admin'))) Role::create(['name' => 'admin']);
        if (is_null(Role::findByName('reader'))) Role::create(['name' => 'reader']); //Только чтение
        if (is_null(Role::findByName('client'))) Role::create(['name' => 'client', 'guard_name' => 'web']);
        if (is_null(Role::findByName('product'))) Role::create(['name' => 'product']);
        if (is_null(Role::findByName('order'))) Role::create(['name' => 'order']);
        if (is_null(Role::findByName('manager'))) Role::create(['name' => 'manager']);

        //Раздел товары
        $productItems = ['create product', 'edit product', 'view product', 'delete product', 'published product'];
        //Раздел продажи
        $orderItems = ['create order', 'edit order', 'view order', 'delete order'];
        //Раздел Настройки
        $settingsItems = ['create settings', 'edit settings', 'view settings', 'delete settings'];
        //Раздел веб-сайт
        $webItems = ['create web', 'edit web', 'view web', 'delete web'];
        //Раздел обратная связь
        $feedItems = ['create feed', 'edit feed', 'view feed', 'delete feed'];
        //Раздел Аналитика
        $analyticItems = ['create analytic', 'edit analytic', 'view analytic', 'delete analytic'];

        $this->createPermission($productItems);
        $this->createPermission($orderItems);
        $this->createPermission($settingsItems);
        $this->createPermission($webItems);
        $this->createPermission($feedItems);
        $this->createPermission($analyticItems);


        $admin = Role::findByName('admin');
        $admin->givePermissionTo(Permission::all());

        $product = Role::findByName('product');
        $product->givePermissionTo($productItems);

        $reader = Role::findByName('reader');
        $reader->givePermissionTo([
            'view product', 'view order', 'view settings', 'view web', 'view feed', 'view analytic',
        ]);

        return true;
    }

    public function createPermission(array $items): void
    {
        foreach ($items as $item)
            if(is_null(Permission::findByName($item))) Permission::create(['name' => $item]);
    }
}

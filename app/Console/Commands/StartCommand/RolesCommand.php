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
        $this->addRole('admin');
        $this->addRole('reader');
        $this->addRole('client');
        $this->addRole('product');
        $this->addRole('order');
        $this->addRole('manager');

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

    private function addRole(string $role): void
    {
        if (is_null(Role::findByParam(['name' => $role, 'guard_name' => 'api']))) Role::create(['name' => $role]);
    }

    public function createPermission(array $items): void
    {
        foreach ($items as $item)
            if(is_null(Permission::getPermission(['name' => $item, 'guard_name' => 'api']))) Permission::create(['name' => $item]);
    }
}

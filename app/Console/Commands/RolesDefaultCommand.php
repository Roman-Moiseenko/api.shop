<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class RolesDefaultCommand extends Command
{
    protected $signature = 'role:create {name}';
    protected $description = 'Command description';

    public function handle(): bool
    {
        $name = $this->argument('name');
        $role = Role::create(['name' => $name]);
        $this->info('Роль создана');
        return true;
    }
}

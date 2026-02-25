<?php

namespace App\Console\Commands;


use App\Modules\Auth\Entity\User;
use App\Modules\Staff\Entity\Staff;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AssignAdminCommand extends Command
{
    protected $signature = 'admin:assign {name}';
    protected $description = 'Command description';


    public function handle(): bool
    {
        $name = $this->argument('name');
        $email = $name . '@shop.api';

        if (is_null($user = User::where('email', $email)->first())) {
            $this->error('Пользователь не найден');
            return false;
        }
        $user->assignRole('admin');

        $this->info('Пользователю ' . $name . ' назначена роль admin');

        return true;
    }
}

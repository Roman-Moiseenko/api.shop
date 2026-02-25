<?php

namespace App\Console\Commands;


use App\Modules\Auth\Entity\User;
use App\Modules\Staff\Entity\Staff;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create {name}';
    protected $description = 'Command description';


    public function handle(): bool
    {
        $name = $this->argument('name');
        $email = $name . '@shop.api';

        if (User::where('email', $email)->first()) {
            $this->error('Пользователь с таким логином уже существует ');
            return false;
        }

        $password = $this->ask('Введите пароль');

        /** @var User $user */
        $user = User::register($email, $password, $name);
        $user->ulid = Str::ulid()->toBase32();
        $user->save();
        $user->assignRole('admin');

        $staff = Staff::register($user->id);
        $this->info('Пользователь ' . $name . ' создан ID='. $staff->id);

        return true;
    }
}

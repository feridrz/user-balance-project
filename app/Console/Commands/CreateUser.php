<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    protected $signature = 'user:create {login} {password}';
    protected $description = 'Добавляет нового пользователя';

    public function handle(): int
    {
        $login = $this->argument('login');
        $password = $this->argument('password');

        if (User::where('login', $login)->exists()) {
            $this->error('Пользователь уже существует.');
            return self::FAILURE;
        }

        $user = User::create([
            'login'    => $login,
            'password' => Hash::make($password),
        ]);

        $user->balance()->create(['amount' => 0]);

        $this->info("Пользователь #{$user->id} создан.");
        return self::SUCCESS;
    }
}

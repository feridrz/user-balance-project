<?php

namespace App\Console\Commands;

use App\Jobs\ProcessBalanceTransaction;
use App\Models\User;
use App\Services\BalanceService;
use Illuminate\Console\Command;

class BalanceOperate extends Command
{
    protected $signature = 'balance:operate
        {login : Логин пользователя}
        {description : Описание операции}
        {--amount= : Сумма, может быть отрицательной}
        {--queue : Выполнить через очередь}';

    protected $description = 'Начисление или списание средств пользователю';

    public function handle(BalanceService $service): int
    {
        $login  = $this->argument('login');
        $desc   = $this->argument('description');
        $amount  = (float) $this->option('amount');
        $queued = $this->option('queue');

        $user = User::where('login', $login)->first();
        if (!$user) {
            $this->error('Пользователь не найден.');
            return self::FAILURE;
        }

        if ($amount === 0.0) {
            $this->error('Сумма не может быть нулевой.');
            return self::FAILURE;
        }

        if ($queued) {
            ProcessBalanceTransaction::dispatch($user->id, $amount, $desc);
            $this->info('Операция поставлена в очередь.');
        } else {
            try {
                $service->operate($user, $amount, $desc);
                $this->info('Операция выполнена.');
            } catch (\Throwable $e) {
                $this->error('Ошибка: ' . $e->getMessage());
                return self::FAILURE;
            }
        }

        return self::SUCCESS;
    }
}

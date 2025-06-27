<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BalanceService
{
    /**
     * @throws ValidationException
     */
    public function operate(User $user, float $amount, string $description): Transaction
    {
        return DB::transaction(function () use ($user, $amount, $description) {
            $balance = $user->balance()->lockForUpdate()->firstOrCreate([], ['amount' => 0]);

            $newAmount = $balance->amount + $amount;
            if ($newAmount < 0) {
                throw ValidationException::withMessages(['balance' => 'Недостаточно средств']);
            }

            $balance->update(['amount' => $newAmount]);

            return $user->transactions()->create([
                'amount'      => $amount,
                'description' => $description,
            ]);
        });
    }
}

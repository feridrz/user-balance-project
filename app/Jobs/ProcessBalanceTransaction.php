<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\BalanceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessBalanceTransaction implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        public int    $userId,
        public float  $amount,
        public string $description
    ) {}

    public function handle(BalanceService $service): void
    {
        $user = User::findOrFail($this->userId);
        $service->operate($user, $this->amount, $this->description);
    }
}

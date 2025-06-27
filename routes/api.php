<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController, TransactionController};

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard',        [DashboardController::class,   'index']);
    Route::get('/transactions',     [TransactionController::class, 'list']);
});

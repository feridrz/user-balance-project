<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load([
            'balance',
            'transactions' => fn ($q) => $q->latest()->take(5),
        ]);

        return response()->json([
            'balance'      => $user->balance?->amount ?? 0,
            'transactions' => $user->transactions->map(function ($t) {
                return [
                    'id'          => $t->id,
                    'amount'      => $t->amount,
                    'description' => $t->description,
                    'created_at'  => $t->created_at->toDateTimeString(),
                ];
            }),
        ]);
    }
}

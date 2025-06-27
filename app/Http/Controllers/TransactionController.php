<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function list(Request $request)
    {
        $query = $request->user()->transactions();

        if ($search = $request->get('search')) {
            $query->where('description', 'like', "%{$search}%");
        }

        $query->orderBy('created_at', $request->get('sort', 'desc'));

        return $query->paginate(20);
    }
}

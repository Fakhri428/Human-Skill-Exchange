<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(): JsonResponse
    {
        $tx = Transaction::with('user')->latest()->get();
        return response()->json(['data' => $tx]);
    }

    public function show(Transaction $transaction): JsonResponse
    {
        return response()->json(['data' => $transaction->load('user')]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'type' => 'required|string',
            'meta' => 'nullable|array',
        ]);
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        $tx = Transaction::create($data);
        return response()->json(['data' => $tx], 201);
    }
}

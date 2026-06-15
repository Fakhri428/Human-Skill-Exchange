<?php

namespace App\Http\Controllers;

use App\Models\MentoringRoom;
use App\Models\Transaction;
use App\Models\User;
use App\Models\MentoringBooking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::orderBy('created_at', 'desc')->limit(50)->get();
        $rooms = MentoringRoom::with(['user', 'mentor'])->latest()->limit(50)->get();
        $transactions = Transaction::with('user')->latest()->limit(50)->get();
        $bookings = MentoringBooking::with(['room', 'user'])->latest()->limit(50)->get();
        return view('admin.dashboard', compact('users', 'rooms', 'transactions', 'bookings'));
    }

    public function approveBooking(Request $request, MentoringBooking $booking)
    {
        $b = MentoringBooking::find($booking->id);
        if ($b) {
            $b->update(['status' => 'approved']);
        }
        return back()->with('status', 'Booking approved.');
    }

    public function declineBooking(Request $request, MentoringBooking $booking)
    {
        $b = MentoringBooking::find($booking->id);
        if ($b) {
            $b->update(['status' => 'declined']);
        }
        return back()->with('status', 'Booking declined.');
    }

    public function completeTransaction(Request $request, \App\Models\Transaction $transaction)
    {
        $t = \App\Models\Transaction::find($transaction->id);
        if ($t) {
            $t->update(['status' => 'completed']);
        }
        return back()->with('status', 'Transaction marked completed.');
    }
}

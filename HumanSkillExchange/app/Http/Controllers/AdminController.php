<?php

namespace App\Http\Controllers;

use App\Models\MentoringRoom;
use App\Models\Transaction;
use App\Models\User;
use App\Models\MentoringBooking;
use App\Notifications\BookingApprovedNotification;
use App\Notifications\BookingDeclinedNotification;
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

    public function approveBooking(Request $request, $booking)
    {
        $bookingRecord = MentoringBooking::findOrFail($booking);
        $bookingRecord->update(['status' => 'approved']);

        // Send notification to user
        $bookingRecord->user->notify(new BookingApprovedNotification($bookingRecord));

        return back()->with('status', 'Booking approved dan notifikasi dikirim.');
    }

    public function declineBooking(Request $request, $booking)
    {
        $bookingRecord = MentoringBooking::findOrFail($booking);
        $bookingRecord->update(['status' => 'declined']);

        // Send notification to user
        $bookingRecord->user->notify(new BookingDeclinedNotification($bookingRecord));

        return back()->with('status', 'Booking declined dan notifikasi dikirim.');
    }

    public function completeTransaction(Request $request, $transaction)
    {
        \App\Models\Transaction::where('id', $transaction)->update(['status' => 'completed']);
        return back()->with('status', 'Transaction marked completed.');
    }
}


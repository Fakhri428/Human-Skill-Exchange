<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MentoringBooking;
use App\Models\MentoringRoom;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MentoringBookingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user->role === 'admin') {
            $bookings = MentoringBooking::with(['room', 'user'])->latest()->get();
        } else {
            $bookings = MentoringBooking::with('room')->where('user_id', $user->id)->latest()->get();
        }

        return response()->json(['data' => $bookings]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'mentoring_room_id' => 'required|integer|exists:mentoring_rooms,id',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        $booking = MentoringBooking::create($data);
        return response()->json(['data' => $booking], 201);
    }

    public function update(Request $request, MentoringBooking $mentoringBooking): JsonResponse
    {
        $this->authorize('update', $mentoringBooking);
        $data = $request->validate([
            'status' => 'sometimes|string',
            'scheduled_at' => 'sometimes|date',
            'duration_minutes' => 'sometimes|integer',
        ]);

        $mentoringBooking->update($data);
        return response()->json(['data' => $mentoringBooking]);
    }
}

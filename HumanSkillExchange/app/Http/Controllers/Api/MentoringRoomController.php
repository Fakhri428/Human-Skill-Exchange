<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MentoringRoom;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MentoringRoomController extends Controller
{
    public function index(): JsonResponse
    {
        $rooms = MentoringRoom::with(['user', 'mentor'])->latest()->get();
        return response()->json(['data' => $rooms]);
    }

    public function show(MentoringRoom $mentoringRoom): JsonResponse
    {
        return response()->json(['data' => $mentoringRoom->load(['user', 'mentor'])]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:191',
            'description' => 'nullable|string',
            'mentor_id' => 'nullable|integer',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'nullable|integer',
            'price' => 'nullable|numeric',
        ]);

        $data['user_id'] = Auth::id();
        $room = MentoringRoom::create($data);
        return response()->json(['data' => $room], 201);
    }

    public function update(Request $request, MentoringRoom $mentoringRoom): JsonResponse
    {
        $this->authorize('update', $mentoringRoom);
        $data = $request->validate([
            'title' => 'sometimes|string|max:191',
            'description' => 'nullable|string',
            'scheduled_at' => 'sometimes|date',
            'duration_minutes' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'status' => 'sometimes|string',
        ]);
        $mentoringRoom->update($data);
        return response()->json(['data' => $mentoringRoom]);
    }

    public function destroy(MentoringRoom $mentoringRoom): JsonResponse
    {
        $this->authorize('delete', $mentoringRoom);
        $mentoringRoom->delete();
        return response()->json([], 204);
    }
}

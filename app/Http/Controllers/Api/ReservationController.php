<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationCreateRequest;
use App\Http\Requests\ReservationDestroyRequest;
use App\Http\Requests\ReservationUpdateRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationController extends Controller
{
    public function show(Request $request, Reservation $reservation): ReservationResource
    {
        return new ReservationResource($reservation);
    }

    public function store(ReservationCreateRequest $request): ReservationResource
    {
        $reservation = $request->user()->reservations()->create($request->validated());

        return new ReservationResource($reservation);
    }

    public function update(ReservationUpdateRequest $request, Reservation $reservation): ReservationResource
    {
        $reservation->update($request->validated());

        return new ReservationResource($reservation->fresh());
    }

    public function destroy(ReservationDestroyRequest $request, Reservation $reservation): JsonResponse
    {
        $reservation->delete();

        return response()->json([], 204);
    }
}

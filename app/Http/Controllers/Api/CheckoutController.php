<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Reservation;
use App\Processors\PriceCalculationProcessor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(
        CheckoutRequest $request,
        PriceCalculationProcessor $processor,
        Reservation $reservation): JsonResponse
    {
        $url = $request->user()->checkoutCharge(
            $processor->process(
                $reservation->id),
                "Reservation #{$reservation->id} ({$reservation->start->format('d-m-Y H:i')} - {$reservation->end->format('d-m-Y H:i')})",
            1,
            [
                'success_url' => "http://localhost:3000/checkout/{$reservation->uuid}?response=success",
                'cancel_url' => "http://localhost:3000",
                'metadata' => [
                    'reservationId' => $reservation->id,
                    'reservationUUID' => $reservation->uuid
                ]
            ]
        )->asStripeCheckoutSession()->url;

        return response()->json(['url' => $url], 200);
    }
}

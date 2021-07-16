<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Notifications\ReservationPaymentSuccesful;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    public function handleCheckoutSessionCompleted(array $payload): JsonResponse
    {
        $reservation = Reservation::findOrFail(Arr::get($payload, 'data.object.metadata.reservationId'));

        $reservation->update([
                'paid_at' => Arr::get($payload, 'created'),
                'paid_amount' => Arr::get($payload, 'data.object.amount_total'),
            ]);

        $reservation->user->notify(new ReservationPaymentSuccesful($reservation));

        return response()->json('', 200);
    }
}

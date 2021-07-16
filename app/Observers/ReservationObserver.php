<?php

namespace App\Observers;

use App\Models\Reservation;
use Illuminate\Support\Str;

class ReservationObserver
{
    public function creating(Reservation $reservation): void
    {
        $reservation->uuid = Str::uuid();

        Reservation::query()
            ->whereNull('paid_at')
            ->where('user_id', $reservation->user_id)
            ->delete();
    }
}

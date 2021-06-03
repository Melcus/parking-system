<?php

namespace App\Observers;

use App\Models\Reservation;

class ReservationObserver
{
    public function creating(Reservation $reservation): void
    {
        Reservation::query()
            ->whereNull('paid_at')
            ->where('user_id', $reservation->user_id)
            ->delete();
    }
}

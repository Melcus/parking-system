<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Reservation $reservation): bool
    {
        return (int)$user->id === (int)$reservation->user_id;
    }

    public function update(User $user, Reservation $reservation): bool
    {
        return (int)$user->id === (int)$reservation->user_id;
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        return (int)$user->id === (int)$reservation->user_id;
    }

    public function pay(User $user, Reservation $reservation): bool
    {
        return (int)$user->id === (int)$reservation->user_id && empty($reservation->paid_at);
    }
}

<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Reservation $reservation)
    {
        //
    }


    public function create(User $user)
    {
        //
    }


    public function update(User $user, Reservation $reservation): bool
    {
        return (int)$user->id === (int)$reservation->user_id;
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        return (int)$user->id === (int)$reservation->user_id;
    }

    public function restore(User $user, Reservation $reservation)
    {
        //
    }

    public function forceDelete(User $user, Reservation $reservation)
    {
        //
    }
}

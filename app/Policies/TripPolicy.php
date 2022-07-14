<?php

namespace App\Policies;

use App\Trip;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TripPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Trip  $trip
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Trip $trip)
    {
        return $user->id == $trip->car->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Trip  $trip
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Trip $trip)
    {
        return $user->id == $trip->car->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Trip  $trip
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Trip $trip)
    {
        return $user->id == $trip->car->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Trip  $trip
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Trip $trip)
    {
        return $user->id == $trip->car->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Trip  $trip
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Trip $trip)
    {
        return $user->id == $trip->car->user_id;
    }
}
<?php

namespace App\Policies;

use App\Models\Agence;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AgencePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role==='ADMINISTRATION' || $user->role==='AGENT' || $user->role==='ADMIN';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Agence $agence): bool
    {
        return $user->role==='ADMINISTRATION' || $user->role==='AGENT' || $user->role==='ADMIN';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role==='ADMINISTRATION';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Agence $agence): bool
    {
        return $user->role==='ADMINISTRATION' ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Agence $agence): bool
    {
        return $user->role==='ADMINISTRATION' ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Agence $agence): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Agence $agence): bool
    {
        return $user->role==='ADMINISTRATION' ;
    }
}

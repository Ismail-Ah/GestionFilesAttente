<?php

namespace App\Policies;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServicePolicy
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
    public function view(User $user, Service $service): bool
    {
        return $user->role==='ADMINISTRATION' || $user->role==='AGENT' || $user->role==='ADMIN';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role==='ADMINISTRATION' ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): bool
    {
        return $user->role==='ADMINISTRATION';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): bool
    {
        return $user->role==='ADMINISTRATION';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service): bool
    {
        return $user->role==='ADMINISTRATION';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        return $user->role==='ADMINISTRATION';
    }

   

        public function prendreTicket(?User $user, Service $service): bool
        {
            $currentDateTime = Carbon::now();

            return $service->etat === 'ACTIF' &&
                $currentDateTime->between(
                    Carbon::createFromFormat('H:i:s', $service->heure_debut),
                    Carbon::createFromFormat('H:i:s', $service->heure_fin)
                );
        }

}

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
        $startTime = Carbon::createFromFormat('H:i:s', $service->heure_debut);
        $endTime = Carbon::createFromFormat('H:i:s', $service->heure_fin);
    
        if ($endTime->lessThan($startTime)) {
            // Service ends after midnight
            return $service->etat === 'ACTIF' &&
                ($currentDateTime->greaterThanOrEqualTo($startTime) || $currentDateTime->lessThanOrEqualTo($endTime));
        } else {
            // Service ends on the same day
            return $service->etat === 'ACTIF' &&
                $currentDateTime->between($startTime, $endTime);
        }
    }
    

}

<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Agence;
use App\Models\Ticket;
use App\Models\Service;
use App\Policies\AgentPolicy;
use App\Policies\AgencePolicy;
use App\Policies\TicketPolicy;
use App\Policies\ServicePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\AgentController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Agence::class, AgencePolicy::class);
        Gate::policy(Service::class, ServicePolicy::class);
        Gate::policy(User::class, AgentPolicy::class);
        Gate::policy(Ticket::class, TicketPolicy::class);
    }

    
}

<?php

use App\Models\Service;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\AddNewFileAttente;
use App\Console\Commands\ResetDailyTickets;



$services = Service::all();
    foreach ($services as $service) {
        // Create DateTime objects from the time strings
        $heureFin = new DateTime($service->heure_fin);
        $heureDebut = new DateTime($service->heure_debut);

        // Add one hour to the end time
        $heureFin->modify('-1 hour');

        // Format times for scheduling
        $formattedHeureFin = $heureFin->format('H:i');
        $formattedHeureDebut = $heureDebut->format('H:i');

        // Schedule commands
        Schedule::call(function () use ($service) {
            Artisan::call('reset:daily_Tickets', ['service_id' => $service->id]);
        })->dailyAt($formattedHeureFin);

        Schedule::call(function () use ($service) {
            Artisan::call('reset:daily_Tickets', ['service_id' => $service->id]);
        })->dailyAt($formattedHeureDebut);

        Schedule::call(function () use ($service) {
            Artisan::call('add:new_file_attente', ['service_id' => $service->id]);
        })->dailyAt($formattedHeureDebut);
    }
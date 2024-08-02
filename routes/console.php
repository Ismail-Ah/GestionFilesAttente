<?php

use App\Models\Service;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\AddNewFileAttente;
use App\Console\Commands\ResetDailyTickets;

$services = Service::all();
foreach ($services as $service){
    Schedule::command('reset:daily_Tickets')->dailyAt($service->heure_fin);
    Schedule::command('reset:daily_Tickets')->dailyAt($service->heure_debut);
    Schedule::command('add:new_file_attente')->dailyAt($service->heure_debut);

}

<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\AddNewFileAttente;
use App\Console\Commands\ResetDailyTickets;

Schedule::command('reset:daily_Tickets')->dailyAt('19:00');
Schedule::command('add:new_file_attente')->dailyAt('7:00');

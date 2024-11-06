<?php

namespace App\Console\Commands;

use App\Models\Service;
use Carbon\Carbon;
use App\Models\Ticket;
use Illuminate\Console\Command;

class ResetDailyTickets extends Command
{
    protected $signature = 'reset:daily_Tickets {service_id}';
    protected $description = 'Delete tickets';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
{
    $serviceId = $this->argument('service_id');
    
    // Find the service by ID
    $service = Service::find($serviceId);
    
    if (!$service) {
        $this->error('Service not found.');
        return;
    }
    
    // Get the latest file attente related to the service
    $latestFileAttente = $service->fileAttente()->latest()->first();
    
    if (!$latestFileAttente) {
        $this->error('No file attente found for this service.');
        return;
    }
    
    // Delete tickets associated with the latest file attente
    Ticket::where('files_attente_id', $latestFileAttente->id)->delete();
    
    $this->info('Tickets deleted successfully.');
}

    
}

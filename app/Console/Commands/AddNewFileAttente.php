<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Files_Attente;
use Illuminate\Console\Command;

class AddNewFileAttente extends Command
{
    protected $signature = 'add:new_file_attente {service_id}';
    protected $description = 'Add new file_attente';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $serviceId = $this->argument('service_id');
        $service = Service::find($serviceId);

        
            Files_Attente::create([
                'service_id' => $service->id,
            ]);
        
        
        $this->info('File_Attente created successfully.');
    }
}

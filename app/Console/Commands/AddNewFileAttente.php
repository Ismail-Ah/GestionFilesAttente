<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Files_Attente;
use Illuminate\Console\Command;

class AddNewFileAttente extends Command
{
    protected $signature = 'add:new_file_attente';
    protected $description = 'Add new file_attente';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $services = Service::all();
        if ($services->isEmpty()) {
            $this->warn('No services found. Skipping file_attente creation.');
            return;
        }

        foreach ($services as $service) {
            Files_Attente::create([
                'service_id' => $service->id,
                'nom' => 'File Attente ' . Carbon::now()->toDateString(),
            ]);
        }
        
        $this->info('File_Attente created successfully.');
    }
}

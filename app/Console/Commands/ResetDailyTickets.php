<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Ticket;
use Illuminate\Console\Command;

class ResetDailyTickets extends Command
{
    protected $signature = 'reset:daily_Tickets';
    protected $description = 'Delete tickets';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {


        Ticket::truncate();
        $this->info('Tickets deleted successfully.');
    }
}

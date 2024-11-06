<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $serviceIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];

        // Generate files d'attente for the last 30 days
        foreach ($serviceIds as $serviceId) {
            for ($i = 0; $i < 30; $i++) {
                $createdAt = Carbon::now()->subDays($i)->toDateTimeString(); // Use past dates

                // Generate realistic number of clients
                $clientsEnAttente = rand(0, 40);
                $clientsTraites = rand(0, 30); // Limit to a reasonable number processed

                // Set realistic average wait time based on clients treated
                if ($clientsTraites > 20) {
                    $tempsMoyenAttente = rand(5, 10); // Short wait if many treated
                } elseif ($clientsTraites > 10) {
                    $tempsMoyenAttente = rand(10, 20); // Moderate wait
                } else {
                    $tempsMoyenAttente = rand(20, 30); // Longer wait if few treated
                }

                // Insert the file d'attente
                DB::table('files_attentes')->insert([
                    'service_id' => $serviceId,
                    'ClientsEnAttentes' => $clientsEnAttente,
                    'ClientsTraites' => $clientsTraites,
                    'tempsMoyenAttente' => $tempsMoyenAttente,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }

        // Generate tickets only for today's file d'attente
        foreach ($serviceIds as $serviceId) {
            $fileAttenteToday = DB::table('files_attentes')
                ->where('service_id', $serviceId)
                ->whereDate('created_at', Carbon::today())
                ->first();

            if ($fileAttenteToday) {
                $numTickets = $fileAttenteToday->ClientsEnAttentes + $fileAttenteToday->ClientsTraites;
                $numTraites = $fileAttenteToday->ClientsTraites;

                $previousCreatedAt = null; // Track the created_at time of the last waiting ticket

                // Insert tickets for today's queue
                for ($i = 1; $i <= $numTickets; $i++) {
                    if ($i <= $numTraites) {
                        $createdAt = now();

                        // Get the last used numéro for the current files_attente_id
                        $lastNum = DB::table('tickets')
                            ->where('files_attente_id', $fileAttenteToday->id)
                            ->max('numéro');

                        // Calculate the next numéro
                        $nextNum = $lastNum ? $lastNum + 1 : 1;

                        // Use realistic and varied service time for processed tickets
                        $serviceTime = rand($fileAttenteToday->tempsMoyenAttente - 2, $fileAttenteToday->tempsMoyenAttente + 2); // Vary service time slightly
                        $updatedAt = $createdAt->copy()->addMinutes($serviceTime);
                    } else {
                        // For waiting tickets
                        if ($previousCreatedAt) {
                            // Ensure the new createdAt is less than or equal to the previous waiting ticket's createdAt
                            $delayMinutes = rand(1, $fileAttenteToday->tempsMoyenAttente);
                            $createdAt = $previousCreatedAt->copy()->subMinutes($delayMinutes);
                        } else {
                            // For the first waiting ticket, use a random delay
                            $delayMinutes = rand(1, $fileAttenteToday->tempsMoyenAttente);
                            $createdAt = now()->subMinutes($delayMinutes);
                        }

                        // Get the last used numéro for the current files_attente_id
                        $lastNum = DB::table('tickets')
                            ->where('files_attente_id', $fileAttenteToday->id)
                            ->max('numéro');

                        // Calculate the next numéro for waiting tickets
                        $nextNum = $lastNum ? $lastNum + 1 : 1;
                        $updatedAt = $createdAt; // Not yet processed
                    }

                    // Insert ticket
                    DB::table('tickets')->insert([
                        'numéro' => $nextNum,
                        'files_attente_id' => $fileAttenteToday->id,
                        'statut' => $i <= $numTraites ? 'TRAITE' : 'EN_ATTENT',
                        'created_at' => $createdAt,
                        'updated_at' => $updatedAt,
                    ]);

                    // Update previousCreatedAt for waiting tickets
                    if ($i > $numTraites) {
                        $previousCreatedAt = $createdAt; // Update for the next waiting ticket
                    }
                }
            }
        }
    }
}

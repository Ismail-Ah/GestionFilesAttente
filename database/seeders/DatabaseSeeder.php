<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    
        

        // Seed files_attentes
        $serviceIds = [8];

        foreach ($serviceIds as $serviceId) {
            for ($i = 0; $i < 30; $i++) {
                $createdAt = Carbon::now()->subDays($i)->toDateTimeString();

                DB::table('files_attentes')->insert([
                    'service_id' => $serviceId,
                    'ClientsEnAttentes' => rand(0, 100),
                    'ClientsTraites' => rand(0, 100),
                    'tempsMoyenAttente' => rand(5, 60),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}

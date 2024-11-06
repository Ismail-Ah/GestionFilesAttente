<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketsTableSeeder extends Seeder
{
    public function run()
{
    $filesAttente = [91, 121, 151, 181, 211, 31, 61, 1];
    $tickets = [[11,3],[40,7],[29,3],[20,5],[18,7],[40,5],[25,5],[4,2]];
    $stats = [];

    foreach ($filesAttente as $index => $fileAttenteId) {
        // Obtenir les valeurs pour les tickets à partir du tableau
        $numTickets = $tickets[$index][0];
        $numTraites = $tickets[$index][1];
        $numEnAttent = $numTickets - $numTraites;

        // Insérer les tickets avec le statut "TRAITE" et "EN_ATTENT"
        for ($i = 1; $i <= $numTickets; $i++) {
            DB::table('tickets')->insert([
                'numéro' => $i,
                'files_attente_id' => $fileAttenteId,
                'statut' => $i <= $numTraites ? 'TRAITE' : 'EN_ATTENT',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Stocker les statistiques pour cette file d'attente
        $stats[] = [
            'file_attente_id' => $fileAttenteId,
            'traite' => $numTraites,
            'en_attent' => $numEnAttent,
        ];
    }

    // Afficher les statistiques à la fin de l'exécution du seeder
    foreach ($stats as $stat) {
        echo "File d'attente ID: {$stat['file_attente_id']} - Tickets TRAITE: {$stat['traite']}, Tickets EN_ATTENT: {$stat['en_attent']}\n";
    }
}

}

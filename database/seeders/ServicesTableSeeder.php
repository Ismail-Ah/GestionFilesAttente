<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('services')->insert([
            // Services pour Agence Hassan
            [
                'nom' => 'Distribution d\'Eau Potable',
                'agence_id' => 1, // ID de l'Agence Hassan
                'etat' => 'ACTIF',
                'heure_debut' => '08:00',
                'heure_fin' => '17:00',
                'nom_en' => 'Drinking Water Distribution',
                'nom_ar' => 'توزيع المياه الصالحة للشرب',
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Assainissement Liquide',
                'agence_id' => 1,
                'etat' => 'ACTIF',
                'heure_debut' => '09:00',
                'heure_fin' => '17:00',
                'nom_en' => 'Liquid Sanitation',
                'nom_ar' => 'الصرف الصحي السائل',
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Service Client',
                'agence_id' => 1,
                'etat' => 'ACTIF',
                'heure_debut' => '08:00',
                'heure_fin' => '16:00',
                'nom_en' => 'Customer Service',
                'nom_ar' => 'خدمة العملاء',
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Services pour Agence Nahda
            [
                'nom' => 'Distribution d\'Électricité',
                'agence_id' => 2, // ID de l'Agence Nahda
                'etat' => 'ACTIF',
                'heure_debut' => '08:00',
                'heure_fin' => '18:00',
                'nom_en' => 'Electricity Distribution',
                'nom_ar' => 'توزيع الكهرباء',
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Travaux de Raccordement',
                'agence_id' => 2,
                'etat' => 'ACTIF',
                'heure_debut' => '09:00',
                'heure_fin' => '17:00',
                'nom_en' => 'Connection Works',
                'nom_ar' => 'أعمال الربط',
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Entretien des Réseaux',
                'agence_id' => 2,
                'etat' => 'ACTIF',
                'heure_debut' => '08:30',
                'heure_fin' => '16:30',
                'nom_en' => 'Network Maintenance',
                'nom_ar' => 'صيانة الشبكات',
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Services pour Agence Amal
            [
                'nom' => 'Service Client',
                'agence_id' => 3, // ID de l'Agence Amal
                'etat' => 'ACTIF',
                'heure_debut' => '08:00',
                'heure_fin' => '16:00',
                'nom_en' => 'Customer Service',
                'nom_ar' => 'خدمة العملاء',
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Gestion des Déchets',
                'agence_id' => 3,
                'etat' => 'ACTIF',
                'heure_debut' => '08:00',
                'heure_fin' => '17:00',
                'nom_en' => 'Waste Management',
                'nom_ar' => 'إدارة النفايات',
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Services pour Agence Agdal
            [
                'nom' => 'Distribution d\'Eau Potable',
                'agence_id' => 4, // ID de l'Agence Agdal
                'etat' => 'ACTIF',
                'heure_debut' => '08:00',
                'heure_fin' => '17:00',
                'nom_en' => 'Drinking Water Distribution',
                'nom_ar' => 'توزيع المياه الصالحة للشرب',
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Distribution d\'Électricité',
                'agence_id' => 4,
                'etat' => 'ACTIF',
                'heure_debut' => '09:00',
                'heure_fin' => '18:00',
                'nom_en' => 'Electricity Distribution',
                'nom_ar' => 'توزيع الكهرباء',
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Entretien des Réseaux',
                'agence_id' => 4,
                'etat' => 'ACTIF',
                'heure_debut' => '08:00',
                'heure_fin' => '16:00',
                'nom_en' => 'Network Maintenance',
                'nom_ar' => 'صيانة الشبكات',
                'user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

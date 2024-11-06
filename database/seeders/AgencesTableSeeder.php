<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('agences')->insert([
            [
                'nom' => 'Agence Hassan',
                'nom_ar' => 'وكالة حسان',
                'adress' => 'Adresse Hassan',
                'telephone' => '0612345678',
                'email' => 'hassan@redal.ma',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Agence Nahda',
                'nom_ar' => 'وكالة النهضة',
                'adress' => 'Adresse Nahda',
                'telephone' => '0612345679',
                'email' => 'nahda@redal.ma',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Agence Amal',
                'nom_ar' => 'وكالة الأمل',
                'adress' => 'Adresse Amal',
                'telephone' => '0612345680',
                'email' => 'amal@redal.ma',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Agence Agdal',
                'nom_ar' => 'وكالة أكدال',
                'adress' => 'Adresse Agdal',
                'telephone' => '0612345681',
                'email' => 'agdal@redal.ma',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

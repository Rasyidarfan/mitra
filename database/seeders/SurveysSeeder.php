<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveysSeeder extends Seeder
{
   public function run()
   {
       DB::table('surveys')->insert([
           [
               'name' => 'Pendataan survei hortikultura Januari',
               'alias' => 'horti',
               'start_date' => '2024-01-04',
               'end_date' => '2024-01-30',
               'mitra' => 5,
               'team_id' => 7, // Pastikan team_id 1 sudah ada di tabel teams
               'created_at' => now(),
               'updated_at' => now()
           ],
           [
               'name' => 'Pendataan survei vimk24 tw1', 
               'alias' => 'vimk',
               'start_date' => '2024-01-04',
               'end_date' => '2024-01-15',
               'mitra' => 5,
               'team_id' => 8,
               'created_at' => now(),
               'updated_at' => now()
           ],
           [
               'name' => 'Pendataan lapangan SHKK tw1',
               'alias' => 'SHKK',
               'start_date' => '2024-01-13',
               'end_date' => '2024-01-27', 
               'mitra' => 6,
               'team_id' => 8,
               'created_at' => now(),
               'updated_at' => now()
           ],
           [
               'name' => 'Pendataan susenas maret 2025',
               'alias' => 'Susenas',
               'start_date' => '2024-02-07',
               'end_date' => '2024-02-21',
               'mitra' => 36,
               'team_id' => 6,
               'created_at' => now(),
               'updated_at' => now()
           ],
           [
               'name' => 'Pengolahan susenas maret 2025',
               'alias' => 'entri Susenas',
               'start_date' => '2024-02-17',
               'end_date' => '2024-03-16',
               'mitra' => 10,
               'team_id' => 11,
               'created_at' => now(),
               'updated_at' => now()
           ],
           [
               'name' => 'Sakernas Februari',
               'alias' => 'Sakernas',
               'start_date' => '2024-02-01',
               'end_date' => '2024-02-14',
               'mitra' => 13,
               'team_id' => 6,
               'created_at' => now(),
               'updated_at' => now()
           ],
           [
               'name' => 'Pendataan survei hortikultura Februari',
               'alias' => 'horti',
               'start_date' => '2024-02-04', 
               'end_date' => '2024-02-28',
               'mitra' => 5,
               'team_id' => 7,
               'created_at' => now(),
               'updated_at' => now()
           ]
       ]);
   }
}
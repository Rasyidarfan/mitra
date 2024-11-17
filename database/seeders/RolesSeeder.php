<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'role' => 'Admin'],
            ['id' => 2, 'role' => 'Kepala'],
            ['id' => 4, 'role' => 'Mitra'],

            // Tambahkan role berikut
            ['id' => 5, 'role' => 'Umum'],
            ['id' => 6, 'role' => 'Sosial'],
            ['id' => 7, 'role' => 'Produksi'],
            ['id' => 8, 'role' => 'Distribusi'],
            ['id' => 9, 'role' => 'Neraca'],
            ['id' => 10, 'role' => 'Nerwilis'],
            ['id' => 11, 'role' => 'Ipds'],
        ]);

        // User id 5 dengan role admin dan ipds
        DB::table('user_roles')->insert([
            [
                'user_id' => 5,
                'role_id' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 5,
                'role_id' => 11, // IPDS
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

       // Role yang tersedia (kecuali Admin dan IPDS yang sudah dipakai user 5)
       $availableRoles = [2,4,5,6,7,8,9,10];

       // User 1-4 dengan 2 role random
       for($userId = 1; $userId <= 4; $userId++) {
           // Ambil 2 role random
           $randomRoles = array_rand($availableRoles, 2);
           
           DB::table('user_roles')->insert([
               [
                   'user_id' => $userId,
                   'role_id' => $availableRoles[$randomRoles[0]],
                   'created_at' => now(),
                   'updated_at' => now()
               ],
               [
                   'user_id' => $userId,
                   'role_id' => $availableRoles[$randomRoles[1]],
                   'created_at' => now(),
                   'updated_at' => now()
               ]
           ]);
       }

    }
}

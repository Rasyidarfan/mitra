<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            RolesSeeder::class,  
            FaqsSeeder::class,
            MitrasSeeder::class,
            SurveysSeeder::class,
            RealSeeder::class,
            RealRoleSeeder::class,
            RealMitraSeeder::class
        ]);
    }
}

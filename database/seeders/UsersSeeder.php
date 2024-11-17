<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'email' => 'test1@mail.com',
                'name' => 'nama 1',
                'nip_9' => '123456789',
                'nip_18' => '2024111720241112345',
                'password' => bcrypt('patrickstar')
            ],[
                'id' => 2,
                'email' => 'test2@mail.com',
                'name' => 'nama 2',
                'nip_9' => '123456789',
                'nip_18' => '2024111720241112345',
                'password' => bcrypt('patrickstar')
            ],[
                'id' => 3,
                'email' => 'test3@mail.com',
                'name' => 'nama 3',
                'nip_9' => '123456789',
                'nip_18' => '2024111720241112345',
                'password' => bcrypt('patrickstar')
            ],[
                'id' => 4,
                'email' => 'test4@mail.com',
                'name' => 'nama 4',
                'nip_9' => '123456789',
                'nip_18' => '2024111720241112345',
                'password' => bcrypt('patrickstar')
            ],[
                'id' => 5,
                'email' => 'aarfanarsyad@gmail.com',
                'name' => 'Ahmad Arfan Arsyad',
                'nip_9' => '123456789',
                'nip_18' => '2024111720241112345',
                'password' => bcrypt('patrickstar')
            ],
        ]);
    }
}

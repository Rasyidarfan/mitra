<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MitrasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mitras = [
            [
                'id' => '970223100053',
                'name' => 'Oliphina Maryance',
                'email' => 'mitra.na@gmail.com',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => Carbon::createFromFormat('d/m/Y', '14/04/1999'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '970223100001', 
                'name' => 'Irwan Syah Putra',
                'email' => 'mitra.Syah@gmail.com',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => Carbon::createFromFormat('d/m/Y', '02/11/1995'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '970223100002',
                'name' => 'Jusi Hutagaol',
                'email' => 'jusi.mitra.ol@gmail.com',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => Carbon::createFromFormat('d/m/Y', '26/11/1989'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '970223100010',
                'name' => "vera putri sia'ba",
                'email' => 'mitra.utri@gmail.com', 
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => Carbon::createFromFormat('d/m/Y', '12/02/1999'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '970223100014',
                'name' => 'Irene victoria Dhanti',
                'email' => 'mitra.victoria@gmail.com',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => Carbon::createFromFormat('d/m/Y', '24/01/1995'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
 
        DB::table('mitras')->insert($mitras);
    }
}

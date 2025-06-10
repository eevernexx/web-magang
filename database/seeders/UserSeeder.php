<?php

namespace Database\Seeders;

use App\Models\AnakMagang;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name'=> 'Admin Kominfo',
            'email'=> 'admin@gmail.com',
            'password'=> 'password',
            'university'=> 'Admin Kominfo',
            'field_of_study'=> 'memek',
            'bidang'=>'bidang komunikasi dan teknologi',
            'status'=> 'approved',
            'role_id' => '1',
        ]);
        User::create([
            'id' => 2,
            'name'=> 'Mehta Pradnyatama',
            'email'=> 'mehta@gmail.com',
            'password'=> 'password',
            'university'=> 'Universitas Indonesia',
            'field_of_study'=> 'Hubungan Internasional',
            'bidang'=>'bidang komunikasi dan teknologi',
            'status'=> 'approved',
            'role_id' => '2',
        ]);

        AnakMagang::create([
            'user_id' => 2,
            'name' => 'Mehta Pradnyatama',
            'asal_sekolah'=> 'Universitas Indonesia',
            'bidang' => 'bidang sekretariat',
            'jurusan' => 'Hubungan Internasional',
            'tanggal_masuk' => '2025-06-01',
            'tanggal_keluar' => '2025-07-01',
        ]);
    }
}

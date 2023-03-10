<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaIWRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 26; $i++)
        {
            {
                DB::table('siswa_ilman_waa_ruuhans')->insert([
                    'siswa_id' => $i,
                    'ilman_waa_ruuhan_id' => mt_rand(1,100),
                    'penilaian_deskripsi_id' => mt_rand(1, 4),
                    'profil_sekolah_id' => 1,
                    'periode_id' => 1,
                    'rapor_siswa_id' => 1
                ]);
            }
        }
    }
}
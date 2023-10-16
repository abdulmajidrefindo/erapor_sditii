<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class IbadahHarian2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ibadah_harians_2')->insert([
            'guru_id' => mt_rand(1,10),
            'nama_kriteria' => 'Sholat',
            'penilaian_deskripsi_id' => 1,
            'nilai' => 'Belum Terlihat',
        ]);
        DB::table('ibadah_harians_2')->insert([
            'guru_id' => mt_rand(1,10),
            'nama_kriteria' => 'Sholat',
            'penilaian_deskripsi_id' => 2,
            'nilai' => 'Mulai Terlihat',
        ]);
        DB::table('ibadah_harians_2')->insert([
            'guru_id' => mt_rand(1,10),
            'nama_kriteria' => 'Sholat',
            'penilaian_deskripsi_id' => 3,
            'nilai' => 'Mulai Berkembang',
        ]);
        DB::table('ibadah_harians_2')->insert([
            'guru_id' => mt_rand(1,10),
            'nama_kriteria' => 'Sholat',
            'penilaian_deskripsi_id' => 4,
            'nilai' => 'Menjadi Kebiasaan',
        ]);
    }
}
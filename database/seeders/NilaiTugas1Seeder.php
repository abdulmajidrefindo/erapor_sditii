<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NilaiTugas1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 100; $i++)
        {
            DB::table('nilai_tugass_1')->insert([
                'nilai' => $i,
                'penilaian_huruf_angka_id' => ($i-101)*-1,
            ]);
        }
    }
}
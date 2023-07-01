<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenilaianHurufAngka extends Model
{
    use HasFactory;
    protected $table = "penilaian_huruf_angkas";
    protected $guarded = ['id'];
    public $timestamps = true;

    public function siswa_tahfidz()
    {
        return $this->hasMany(SiswaTahfidz::class);
    }
    public function siswa_doa()
    {
        return $this->hasMany(SiswaDoa::class);
    }
    public function siswa_hadist()
    {
        return $this->hasMany(SiswaHadist::class);
    }
    public function siswa_bidang_studi()
    {
        return $this->hasMany(SiswaBidangStudi::class);
    }
    public function tahfidz_1()
    {
        return $this->hasMany(Tahfidz1::class);
    }
    public function tahfidz_2()
    {
        return $this->hasMany(Tahfidz2::class);
    }
    public function tahfidz_3()
    {
        return $this->hasMany(Tahfidz3::class);
    }
    public function tahfidz_4()
    {
        return $this->hasMany(Tahfidz4::class);
    }
    public function tahfidz_5()
    {
        return $this->hasMany(Tahfidz5::class);
    }
    public function tahfidz_6()
    {
        return $this->hasMany(Tahfidz6::class);
    }
    public function tahfidz_7()
    {
        return $this->hasMany(Tahfidz7::class);
    }
    public function tahfidz_8()
    {
        return $this->hasMany(Tahfidz8::class);
    }
    public function tahfidz_9()
    {
        return $this->hasMany(Tahfidz9::class);
    }
    public function tahfidz_10()
    {
        return $this->hasMany(Tahfidz10::class);
    }
    public function tahfidz_11()
    {
        return $this->hasMany(Tahfidz11::class);
    }
    public function tahfidz_12()
    {
        return $this->hasMany(Tahfidz12::class);
    }
    public function tahfidz_13()
    {
        return $this->hasMany(Tahfidz13::class);
    }
    public function tahfidz_14()
    {
        return $this->hasMany(Tahfidz14::class);
    }
    public function tahfidz_15()
    {
        return $this->hasMany(Tahfidz15::class);
    }
    public function doa_1()
    {
        return $this->hasMany(Doa1::class);
    }
    public function doa_2()
    {
        return $this->hasMany(Doa2::class);
    }
    public function doa_3()
    {
        return $this->hasMany(Doa3::class);
    }
    public function doa_4()
    {
        return $this->hasMany(Doa4::class);
    }
    public function doa_5()
    {
        return $this->hasMany(Doa5::class);
    }
    public function doa_6()
    {
        return $this->hasMany(Doa6::class);
    }
    public function doa_7()
    {
        return $this->hasMany(Doa7::class);
    }
    public function doa_8()
    {
        return $this->hasMany(Doa8::class);
    }
    public function doa_9()
    {
        return $this->hasMany(Doa9::class);
    }
    public function hadist_1()
    {
        return $this->hasMany(Hadist1::class);
    }
    public function hadist_2()
    {
        return $this->hasMany(Hadist2::class);
    }
    public function hadist_3()
    {
        return $this->hasMany(Hadist3::class);
    }
    public function hadist_4()
    {
        return $this->hasMany(Hadist4::class);
    }
    public function hadist_5()
    {
        return $this->hasMany(Hadist5::class);
    }
    public function hadist_6()
    {
        return $this->hasMany(Hadist6::class);
    }
    public function hadist_7()
    {
        return $this->hasMany(Hadist7::class);
    }
    public function hadist_8()
    {
        return $this->hasMany(Hadist8::class);
    }
    public function hadist_9()
    {
        return $this->hasMany(Hadist9::class);
    }
    public function nilai_uh1()
    {
        return $this->hasMany(NilaiUh1::class);
    }
    public function nilai_uh2()
    {
        return $this->hasMany(NilaiUh2::class);
    }
    public function nilai_uh3()
    {
        return $this->hasMany(NilaiUh3::class);
    }
    public function nilai_uh4()
    {
        return $this->hasMany(NilaiUh4::class);
    }
    public function nilai_tugas_1()
    {
        return $this->hasMany(NilaiTugas1::class);
    }
    public function nilai_tugas_2()
    {
        return $this->hasMany(NilaiTugas2::class);
    }
    public function nilai_uts()
    {
        return $this->hasMany(NilaiUts::class);
    }
    public function nilai_pas()
    {
        return $this->hasMany(NilaiPas::class);
    }
}

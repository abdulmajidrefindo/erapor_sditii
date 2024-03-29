<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenilaianDeskripsi extends Model
{
    use HasFactory;
    protected $table = "penilaian_deskripsis";
    protected $guarded = ['id'];
    public $timestamps = true;

    public function siswa_ibadah_harian()
    {
        return $this->hasMany(SiswaIbadahHarian::class);
    }
    public function siswa_iwr()
    {
        return $this->hasMany(SiswaIlmanWaaRuuhan::class);
    }
}

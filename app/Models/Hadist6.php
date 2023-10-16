<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hadist6 extends Model
{
    use HasFactory;
    protected $table = "hadists_6";
    protected $guarded = ['id'];
    public $timestamps = true;

    public function siswa_hadist()
    {
        return $this->hasMany(SiswaHadist::class);
    }
    public function penilaian_huruf_angka()
    {
        return $this->belongsTo(PenilaianHurufAngka::class);
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
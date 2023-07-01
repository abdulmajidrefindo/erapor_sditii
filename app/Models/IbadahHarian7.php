<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IbadahHarian7 extends Model
{
    use HasFactory;
    protected $table = "ibadah_harians_7";
    protected $guarded = ['id'];
    public $timestamps = true;

    public function siswa_ibadah_harian()
    {
        return $this->hasMany(SiswaIbadahHarian::class);
    }
    public function penilaian_deskripsi()
    {
        return $this->belongsTo(PenilaianDeskripsi::class);
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}

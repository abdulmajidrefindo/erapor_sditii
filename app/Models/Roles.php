<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "roles";
    protected $fillable = ['id','role_name','keterangan','created_at','updated_at'];
    public $timestamps = true;
}

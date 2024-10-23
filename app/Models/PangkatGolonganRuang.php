<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PangkatGolonganRuang extends Model
{
    use SoftDeletes;
    
    protected $table = 'pangkat_golongan_ruang';

    public $timestamps = false;

    protected $fillable = [
        'kode', 'pangkat', 'golongan', 'ruang'
    ];
}

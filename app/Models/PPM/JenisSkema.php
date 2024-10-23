<?php

namespace App\Models\PPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSkema extends Model
{
    use HasFactory;

    protected $table = 'ppm_jenis_skema';

    public $timestamps = false;

    protected $fillable = [
        'kode', 'nama'
    ];
}

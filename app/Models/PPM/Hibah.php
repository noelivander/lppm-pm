<?php

namespace App\Models\LPPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Hibah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ppm_hibah';

    public $timestamps = false;

    protected $fillable = [
        'jenis_hibah_id', 'nama', 'singkatan', 'deskripsi'
    ];

    public function jenis_hibah() {
        return $this->belongsTo('App\Models\PPM\JenisSkema', 'jenis_hibah_id', 'id');
    }
}

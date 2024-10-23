<?php

namespace App\Models\PPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    use HasFactory;

    protected $table = 'ppm_skema';

    public $timestamps = false;

    protected $fillable = [
        'kode', 'nama', 'perihal', 'is_research','jenis_skema_id'
    ];

    public function jenis_skema() {
        return $this->belongsTo('App\Models\PPM\JenisSkema', 'jenis_skema_id', 'id');
    }
}

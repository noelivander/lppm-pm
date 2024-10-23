<?php

namespace App\Models\PPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FokusBidang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ppm_fokus_bidang';

    protected $fillable = [
        'pegawai_id', 'nama', 'slug', 'singkatan', 'deskripsi'
    ];

    public function pegawai() {
        return $this->belongsTo('App\Models\Pegawai', 'pegawai_id', 'id');
    }

    public function scopeMenu() {
        return $this->select(['nama','slug']);
    }
}

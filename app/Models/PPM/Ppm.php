<?php

namespace App\Models\LPPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Ppm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ppm';

    protected $fillable = [
        'bidang_id', 'hibah_id', 'pegawai_id', 'luaran_id', 'judul', 'slug', 'deskripsi', 'jurusan_id', 'skema_id', 'jumlah_dana', 'keterangan', 'tahapan'
    ];

    public function bidang() {
        return $this->belongsTo('App\Models\PPM\Bidang', 'bidang_id', 'id');
    }

    public function hibah() {
        return $this->belongsTo('App\Models\PPM\Hibah', 'hibah_id', 'id');
    }

    public function luaran() {
        return $this->belongsTo('App\Models\PPM\Luaran', 'luaran_id', 'id');
    }

    public function pegawai() {
        return $this->belongsTo('App\Models\Pegawai', 'pegawai_id', 'id');
    }
}

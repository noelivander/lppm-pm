<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use SoftDeletes;
    
    protected $table = 'pegawai';

    protected $fillable = [
        'user_id', 'nama', 'email', 'nip', 'program_studi_id', 'jabatan_id', 'pangkat_golongan_ruang_id','foto','is_shown'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function program_studi() {
        return $this->belongsTo('App\Models\ProgramStudi', 'program_studi_id', 'id');
    }

    public function jabatan() {
        return $this->belongsTo('App\Models\Jabatan', 'jabatan_id', 'id');
    }

    public function pangkat_golongan_ruang() {
        return $this->belongsTo('App\Models\PangkatGolonganRuang', 'pangkat_golongan_ruang_id', 'id');
    }
}

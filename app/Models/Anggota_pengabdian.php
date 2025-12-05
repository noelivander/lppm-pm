<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota_pengabdian extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengabdian_id',
        'nama',
        'jabatan',
        'nidn',
        'peran',
        'email',
        'telepon',
        'jurusan_id',
        'program_studi_id',
        'jurusan_nama',
        'program_studi_nama'
    ];

    public function pengabdian()
    {
        return $this->belongsTo(Pengabdian::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(\App\Models\Jurusan::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(\App\Models\ProgramStudi::class, 'program_studi_id');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'penelitian_id',
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

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class);
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


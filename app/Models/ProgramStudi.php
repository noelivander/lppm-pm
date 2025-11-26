<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use SoftDeletes;
    
    protected $table = 'program_studi';

    protected $fillable = [
        'jurusan_id', 'nama', 'kode', 'tahun', 'urutan'
    ];

    public function jurusan() {
        return $this->belongsTo('App\Models\Jurusan', 'jurusan_id', 'id');
    }

    public function pegawai()
    {
        return $this->hasMany('App\Models\Pegawai', 'program_studi_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota_pengabdian extends Model
{
    use HasFactory;

    protected $fillable = ['pengabdian_id', 'nama', 'peran', 'email', 'telepon'];

    public function pengabdian()
    {
        return $this->belongsTo(Pengabdian::class);
    }
}


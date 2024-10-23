<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = ['penelitian_id', 'nama', 'peran', 'email', 'telepon'];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class);
    }
}


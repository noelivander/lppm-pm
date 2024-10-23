<?php

namespace App\Models\PPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Luaran extends Model
{
    use HasFactory;

    protected $table = 'ppm_luaran';

    public $timestamps = false;

    protected $fillable = [
        'kode', 'nama', 'perihal'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use SoftDeletes;

    protected $table = 'jurusan';

    public $timestamps = false;

    protected $fillable = [
        'kode', 'nama', 'tahun', 'urutan'
    ];
}

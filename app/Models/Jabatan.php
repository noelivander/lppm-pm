<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use SoftDeletes;
    
    protected $table = 'jabatan';

    public $timestamps = false;

    protected $fillable = [
        'kode', 'nama', 'is_fungsional', 'tingkatan'
    ];
}

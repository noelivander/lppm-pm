<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flags extends Model
{
    public $timestamps = false;
    
    protected $table = 'flags';

    protected $fillable = [
        'nama'
    ];
}

<?php

namespace App\Models\PPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangPenelitian extends Model
{
    use HasFactory;

    protected $table = 'bidang_penelitian';

    protected $fillable = [
        'nama',
        'kode',
        'urutan',
        'is_active',
    ];
}


<?php

namespace App\Models\PPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangPenelitian extends Model
{
    use HasFactory;

    protected $table = 'bidang_penelitian';

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'kode',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship dengan penelitian
    public function penelitian()
    {
        return $this->hasMany('App\Models\Penelitian', 'bidang_penelitian_id', 'id');
    }
}


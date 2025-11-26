<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanRab extends Model
{
    use HasFactory;

    protected $table = 'satuan_rab';

    protected $fillable = [
        'nama',
        'singkatan',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Komponen yang bisa menggunakan satuan ini
     */
    public function komponen()
    {
        return $this->belongsToMany(KomponenRab::class, 'komponen_satuan_rab', 'satuan_rab_id', 'komponen_rab_id')
            ->withTimestamps();
    }
}

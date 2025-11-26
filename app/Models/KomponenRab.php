<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenRab extends Model
{
    use HasFactory;

    protected $table = 'komponen_rab';

    protected $fillable = [
        'nama',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Satuan yang bisa digunakan untuk komponen ini
     */
    public function satuan()
    {
        return $this->belongsToMany(SatuanRab::class, 'komponen_satuan_rab', 'komponen_rab_id', 'satuan_rab_id')
            ->withTimestamps();
    }
}

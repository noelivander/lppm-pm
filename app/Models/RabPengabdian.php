<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabPengabdian extends Model
{
    use HasFactory;

    protected $table = 'rab_pengabdians';

    protected $fillable = [
        'pengabdian_id',
        'kelompok',
        'komponen',
        'item',
        'satuan',
        'volume',
        'harga_satuan',
        'total',
    ];

    protected $casts = [
        'volume' => 'integer',
        'harga_satuan' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function pengabdian()
    {
        return $this->belongsTo(Pengabdian::class);
    }
}

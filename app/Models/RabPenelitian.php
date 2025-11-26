<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabPenelitian extends Model
{
    use HasFactory;

    protected $table = 'rab_penelitians';

    protected $fillable = [
        'penelitian_id',
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

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class);
    }
}

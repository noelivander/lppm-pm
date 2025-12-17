<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkhirReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_akhir_id',
        'reviewer_id',
        'jenis', // penelitian, pengabdian
        'status',
        'catatan_umum',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function laporanAkhir()
    {
        return $this->belongsTo(LaporanAkhir::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function items()
    {
        return $this->hasMany(LaporanAkhirReviewItem::class);
    }
}

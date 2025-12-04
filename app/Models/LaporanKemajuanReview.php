<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKemajuanReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_kemajuan_id',
        'reviewer_id',
        'jenis',
        'status',
        'catatan_umum',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function laporanKemajuan()
    {
        return $this->belongsTo(LaporanKemajuan::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function items()
    {
        return $this->hasMany(LaporanKemajuanReviewItem::class);
    }
}


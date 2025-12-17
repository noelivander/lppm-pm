<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanAkhir extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laporan_akhir';

    protected $fillable = [
        'penelitian_id',
        'pengabdian_id',
        'laporan_akhir',
        'laporan_keuangan_tahap_2',
        'status',
        'user_id',
        'catatan',
    ];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class);
    }

    public function pengabdian()
    {
        return $this->belongsTo(Pengabdian::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewerEvaluations()
    {
        return $this->hasMany(LaporanAkhirReview::class);
    }

    // Alias umum: reviews
    public function reviews()
    {
        return $this->hasMany(LaporanAkhirReview::class);
    }

    // Helper method to get the proposal (either penelitian or pengabdian)
    public function proposal()
    {
        return $this->penelitian_id ? $this->penelitian : $this->pengabdian;
    }
}

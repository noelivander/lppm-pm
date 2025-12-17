<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKemajuanReviewItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_kemajuan_review_id',
        'form_penilaian_laporan_kemajuan_id',
        'form_penilaian_laporan_kemajuan_sub_id',
        'komentar',
        'nilai',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    public function review()
    {
        return $this->belongsTo(LaporanKemajuanReview::class, 'laporan_kemajuan_review_id');
    }

    public function formPenilaian()
    {
        return $this->belongsTo(FormPenilaianLaporanKemajuan::class, 'form_penilaian_laporan_kemajuan_id');
    }

    public function formPenilaianLaporanKemajuan()
    {
        return $this->belongsTo(FormPenilaianLaporanKemajuan::class, 'form_penilaian_laporan_kemajuan_id');
    }

    public function subFormPenilaian()
    {
        return $this->belongsTo(FormPenilaianLaporanKemajuanSub::class, 'form_penilaian_laporan_kemajuan_sub_id');
    }

    public function formPenilaianLaporanKemajuanSub()
    {
        return $this->belongsTo(FormPenilaianLaporanKemajuanSub::class, 'form_penilaian_laporan_kemajuan_sub_id');
    }

    /**
     * Alias for formPenilaianLaporanKemajuanSub to match view and controller usage
     */
    public function subKriteria()
    {
        return $this->belongsTo(FormPenilaianLaporanKemajuanSub::class, 'form_penilaian_laporan_kemajuan_sub_id');
    }
    public function getSkorAttribute()
    {
        return $this->nilai;
    }
}

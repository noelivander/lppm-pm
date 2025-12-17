<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkhirReviewItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_akhir_review_id',
        'form_penilaian_id',
        'sub_id_status',
        'sub_id_bobot',
        'sub_id',
        'nilai',
        'catatan',
    ];

    public function review()
    {
        return $this->belongsTo(LaporanAkhirReview::class, 'laporan_akhir_review_id');
    }

    public function formPenilaian()
    {
        return $this->belongsTo(FormPenilaianLaporanAkhir::class, 'form_penilaian_id');
    }

    // Relation for Status Choice (Penelitian)
    public function statusChoice()
    {
        return $this->belongsTo(FormPenilaianLaporanAkhirSub::class, 'sub_id_status');
    }

    // Relation for Bobot Choice (Penelitian)
    public function bobotChoice()
    {
        return $this->belongsTo(FormPenilaianLaporanAkhirSub::class, 'sub_id_bobot');
    }

    // Relation for Standard Choice (Pengabdian) or generic use
    public function subChoice()
    {
        return $this->belongsTo(FormPenilaianLaporanAkhirSub::class, 'sub_id');
    }
}

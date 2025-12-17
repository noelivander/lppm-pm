<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPenilaianLaporanAkhir extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'komponen_penilaian',
        'kategori',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function subKomponen()
    {
        return $this->hasMany(FormPenilaianLaporanAkhirSub::class, 'form_penilaian_laporan_akhir_id')->orderBy('urutan');
    }

    public function hasBeenUsed()
    {
        // Check if this form component is referenced in any review items
        return \App\Models\LaporanAkhirReviewItem::where('form_penilaian_id', $this->id)->exists();
    }
}

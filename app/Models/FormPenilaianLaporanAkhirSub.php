<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPenilaianLaporanAkhirSub extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_penilaian_laporan_akhir_id',
        'parent_id',
        'keterangan', // Label
        'skor', // Value (80 or 100 or 10)
        'tipe', // 'standard', 'status', 'bobot_item'
        'urutan',
    ];

    public function formPenilaian()
    {
        return $this->belongsTo(FormPenilaianLaporanAkhir::class, 'form_penilaian_laporan_akhir_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('urutan');
    }
}

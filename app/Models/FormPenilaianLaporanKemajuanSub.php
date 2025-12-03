<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPenilaianLaporanKemajuanSub extends Model
{
    use HasFactory;

    protected $table = 'form_penilaian_laporan_kemajuan_sub';

    protected $fillable = [
        'form_penilaian_id',
        'sub_komponen',
        'nilai',
        'urutan',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    public function formPenilaian()
    {
        return $this->belongsTo(FormPenilaianLaporanKemajuan::class, 'form_penilaian_id');
    }
}

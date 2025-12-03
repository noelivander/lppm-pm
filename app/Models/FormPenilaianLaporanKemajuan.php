<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPenilaianLaporanKemajuan extends Model
{
    use HasFactory;

    protected $table = 'form_penilaian_laporan_kemajuan';

    protected $fillable = [
        'jenis',
        'kategori',
        'komponen_penilaian',
        'urutan',
    ];

    public function subKomponen()
    {
        return $this->hasMany(FormPenilaianLaporanKemajuanSub::class, 'form_penilaian_id')->orderBy('urutan');
    }
}

<?php

namespace App\Models\PPM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    use HasFactory;

    protected $table = 'ppm_skema';

    public $timestamps = true;

    protected $fillable = [
        'kode',
        'nama',
        'perihal',
        'is_research',
        'jenis_skema_id',
        'jenis',
        'is_shown',
        'template_laporan_kemajuan',
        'template_laporan_keuangan_tahap_1',
        'template_laporan_akhir',
        'template_laporan_keuangan_tahap_2'
    ];

    public function jenis_skema()
    {
        return $this->belongsTo('App\Models\PPM\JenisSkema', 'jenis_skema_id', 'id');
    }
}

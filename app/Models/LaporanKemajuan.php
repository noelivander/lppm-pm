<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanKemajuan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laporan_kemajuan';

    protected $fillable = [
        'penelitian_id',
        'pengabdian_id',
        'laporan_kemajuan',
        'laporan_keuangan_tahap_1',
        'tahap',
        'status',
        'user_id',
        'catatan',
    ];

    protected $casts = [
        'tahap' => 'integer',
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

    // Helper method to get the proposal (either penelitian or pengabdian)
    public function proposal()
    {
        return $this->penelitian_id ? $this->penelitian : $this->pengabdian;
    }
}

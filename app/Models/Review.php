<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'penelitian_id', 'pengabdian_id', 'judul_kegiatan', 'ketua_tim', 'nidn', 
        'jabatan', 'scopus', 'anggota', 'biaya_usulan', 'disarankan',
        'skor_1', 'skor_2', 'skor_3', 'skor_4', 'skor_5',
        'komentar', 'reviewer_id'
    ];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class);
    }

    public function pengabdian()
    {
        return $this->belongsTo(Pengabdian::class);
    }
}


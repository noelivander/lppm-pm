<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'penelitian_id',
        'pengabdian_id',
        'judul_kegiatan',
        'ketua_tim',
        'nidn',
        'jabatan',
        'scopus',
        'anggota',
        'biaya_usulan',
        'disarankan',
        'skor_1',
        'skor_2',
        'skor_3',
        'skor_4',
        'skor_5',
        'komentar',
        'reviewer_id',
        'reviewer_name',
        // Kolom khusus untuk hasil review revisi (ACC/Tolak + komentar)
        'revision_decision',
        'revision_comment',
    ];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class);
    }

    public function pengabdian()
    {
        return $this->belongsTo(Pengabdian::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewKriteria()
    {
        return $this->hasMany(ReviewKriteria::class);
    }
}


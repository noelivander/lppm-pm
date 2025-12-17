<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengabdian extends Model
{
    use HasFactory;

    protected $table = 'pengabdian';

    protected $fillable = [
        'judul',
        'luaran_wajib',
        'lama_penelitian',
        'biaya_diusulkan',
        'sinta_index',
        'skema',
        'luaran_tambahan',
        'ringkasan_proposal',
        'dokumen_proposal',
        'status',
        'user_id',
        'is_draft',
        'is_revised',
        'revised_from_id',
        'admin_status',
        'admin_comment',
        'biaya_disetujui'
    ];

    protected $casts = [
        'is_draft' => 'boolean',
        'is_revised' => 'boolean',
    ];

    public function revisionParent()
    {
        return $this->belongsTo(self::class, 'revised_from_id');
    }

    public function revisionChild()
    {
        return $this->hasOne(self::class, 'revised_from_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'pengabdian_id');
    }

    public function anggota()
    {
        return $this->hasMany(Anggota_pengabdian::class);
    }

    public function rab()
    {
        return $this->hasMany(RabPengabdian::class);
    }

    public function laporanKemajuan()
    {
        return $this->hasMany(LaporanKemajuan::class);
    }

    public function laporanAkhir()
    {
        return $this->hasOne(LaporanAkhir::class);
    }

}


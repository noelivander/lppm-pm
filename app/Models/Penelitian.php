<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    use HasFactory;

    protected $table = 'penelitian';

    protected $fillable = [
        'judul', 'luaran_wajib', 'lama_penelitian', 'biaya_diusulkan', 'sinta_index', 
        'skema', 'luaran_tambahan', 'ringkasan_proposal', 'dokumen_proposal', 
        'status', 'user_id', 'is_draft', 'is_revised', 'revised_from_id', 'admin_status', 'admin_comment'
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
    public function anggota()
    {
        return $this->hasMany(Anggota::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'penelitian_id');
    }

    public function rab()
    {
        return $this->hasMany(RabPenelitian::class);
    }

    public function laporanKemajuan()
    {
        return $this->hasMany(LaporanKemajuan::class);
    }

}


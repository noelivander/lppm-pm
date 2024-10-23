<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengabdian extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'luaran_wajib', 'lama_penelitian', 'biaya_diusulkan', 
        'skema', 'luaran_tambahan', 'ringkasan_proposal', 'dokumen_proposal', 
        'status', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'pengabdian_id');
    }

}


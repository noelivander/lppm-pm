<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'announcements';

    protected $fillable = [
        'slug', 'user_id', 'judul', 'isi', 'dokumen', 'is_shown', 'cover', 'tag'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function scopeTerbaru() {
        return $this->select(['judul','slug','cover','created_at'])->orderBy('created_at','desc')->take(3);
    }
}

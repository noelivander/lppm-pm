<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    
    protected $table = 'news';

    protected $fillable = [
        'slug', 'user_id', 'judul', 'isi', 'cover', 'is_shown'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function scopeTerbaru() {
        return $this->select(['judul','slug','cover','created_at'])->orderBy('created_at','desc')->take(3);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    
    protected $table = 'agendas';

    protected $fillable = [
        'user_id', 'tag', 'judul', 'lokasi', 'slug', 'jadwal', 'jadwal_akhir', 'deskripsi', 'is_shown', 'tautan', 'cover'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function scopeTerbaru() {
        return $this->select(['judul','slug','jadwal','jadwal_akhir','lokasi','tag'])->orderBy('jadwal','desc')->take(3);
    }
}

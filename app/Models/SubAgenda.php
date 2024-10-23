<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAgenda extends Model
{
    use HasFactory;
    
    protected $table = 'sub_agendas';

    protected $fillable = [
        'agenda_id', 'tag', 'judul', 'lokasi', 'slug', 'jadwal', 'jadwal_akhir', 'deskripsi', 'is_shown', 'tautan'
    ];

    public function agenda() {
        return $this->belongsTo('App\Models\Agenda', 'agenda_id', 'id');
    }
}

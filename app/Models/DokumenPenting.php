<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokumenPenting extends Model
{
    use SoftDeletes;
    
    protected $table = 'dokumen_penting';

    protected $fillable = [
        'slug','judul', 'file', 'folder', 'label', 'urutan','is_shown', 'is_lock', 'cover'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedLink extends Model
{
    use HasFactory;
    
    protected $table = 'related_links';

    protected $fillable = [
        'nama', 'url'
    ];
}
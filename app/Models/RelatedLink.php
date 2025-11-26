<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelatedLink extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'related_links';

    protected $fillable = [
        'nama', 'url'
    ];
}

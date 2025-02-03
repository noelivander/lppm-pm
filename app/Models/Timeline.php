<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'upload_start_date',
        'upload_end_date',
        'review_start_date',
        'review_end_date',
    ];
}

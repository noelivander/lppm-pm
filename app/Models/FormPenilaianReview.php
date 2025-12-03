<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPenilaianReview extends Model
{
    use HasFactory;

    protected $table = 'form_penilaian_review';

    protected $fillable = [
        'jenis',
        'kriteria_penilaian',
        'bobot',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'bobot' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}

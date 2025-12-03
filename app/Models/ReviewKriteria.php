<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewKriteria extends Model
{
    use HasFactory;

    protected $table = 'review_kriteria';

    protected $fillable = [
        'review_id',
        'form_penilaian_review_id',
        'skor',
        'nilai',
    ];

    protected $casts = [
        'skor' => 'integer',
        'nilai' => 'decimal:2',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function formPenilaianReview()
    {
        return $this->belongsTo(FormPenilaianReview::class);
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'penelitian_id', 'pengabdian_id', 'reviewer_id', 'reviewer_name', 'background', 
        'research_objective', 'methodology', 'results', 'strengths', 
        'weaknesses', 'discussion'
    ];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class);
    }

    public function pengabdian()
    {
        return $this->belongsTo(Pengabdian::class);
    }
}


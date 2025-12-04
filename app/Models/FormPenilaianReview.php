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

    public function reviewKriteria()
    {
        return $this->hasMany(\App\Models\ReviewKriteria::class, 'form_penilaian_review_id');
    }

    /**
     * Get forms that were active on a specific date (for historical data viewing)
     * This method ignores current is_active status and returns forms that existed on the given date
     * 
     * @param string $jenis
     * @param \Carbon\Carbon|string $date
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActiveFormsForDate($jenis, $date)
    {
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }
        
        // Get all forms that existed on the given date
        // This ensures historical data integrity even if forms are later deactivated or deleted
        // We get forms that were created before or on the date
        return static::where('jenis', $jenis)
            ->where('created_at', '<=', $date)
            ->orderBy('urutan')
            ->get();
    }

    /**
     * Check if this form has been used in any review
     * 
     * @return bool
     */
    public function hasBeenUsed()
    {
        // Check if this form has been used in any review_kriteria
        return $this->reviewKriteria()->exists();
    }
}

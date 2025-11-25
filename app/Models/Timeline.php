<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'title',
        'description',
        'upload_start_date',
        'upload_end_date',
        'review_start_date',
        'review_end_date',
        'revision_start_date',
        'revision_end_date',
        'progress_submission_start_date',
        'progress_submission_end_date',
        'progress_review_start_date',
        'progress_review_end_date',
        'final_submission_start_date',
        'final_submission_end_date',
        'final_review_start_date',
        'final_review_end_date',
        'is_active',
        'order',
    ];

    protected $casts = [
        'upload_start_date' => 'datetime',
        'upload_end_date' => 'datetime',
        'review_start_date' => 'datetime',
        'review_end_date' => 'datetime',
        'revision_start_date' => 'datetime',
        'revision_end_date' => 'datetime',
        'progress_submission_start_date' => 'datetime',
        'progress_submission_end_date' => 'datetime',
        'progress_review_start_date' => 'datetime',
        'progress_review_end_date' => 'datetime',
        'final_submission_start_date' => 'datetime',
        'final_submission_end_date' => 'datetime',
        'final_review_start_date' => 'datetime',
        'final_review_end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Scope untuk filter berdasarkan periode
     */
    public function scopeByPeriod($query, $period)
    {
        return $query->where('period', $period);
    }

    /**
     * Scope untuk timeline yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk ordering
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('upload_start_date', 'asc');
    }

    /**
     * Get all unique periods
     */
    public static function getAllPeriods()
    {
        return self::select('period')
            ->distinct()
            ->orderBy('period', 'desc')
            ->pluck('period');
    }

    /**
     * Check if timeline is currently active (within date range)
     */
    public function isCurrentlyActive()
    {
        $now = Carbon::now();
        return $now->between($this->upload_start_date, $this->review_end_date);
    }

    /**
     * Get status of timeline
     */
    public function getStatus()
    {
        $now = Carbon::now();
        
        if ($now->lt($this->upload_start_date)) {
            return 'upcoming';
        } elseif ($now->between($this->upload_start_date, $this->upload_end_date)) {
            return 'upload';
        } elseif ($now->between($this->review_start_date, $this->review_end_date)) {
            return 'review';
        } else {
            return 'completed';
        }
    }

    /**
     * Get status label
     */
    public function getStatusLabel()
    {
        $status = $this->getStatus();
        
        return match($status) {
            'upcoming' => 'Akan Datang',
            'upload' => 'Upload Berlangsung',
            'review' => 'Review Berlangsung',
            'completed' => 'Selesai',
            default => 'Unknown',
        };
    }

    /**
     * Get status color
     */
    public function getStatusColor()
    {
        $status = $this->getStatus();
        
        return match($status) {
            'upcoming' => 'info',
            'upload' => 'primary',
            'review' => 'warning',
            'completed' => 'success',
            default => 'secondary',
        };
    }
}

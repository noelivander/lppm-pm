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
        'admin_decision_start_date',
        'admin_decision_end_date',
        'revision_start_date',
        'revision_end_date',
        'revision_review_start_date',
        'revision_review_end_date',
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
        'admin_decision_start_date' => 'datetime',
        'admin_decision_end_date' => 'datetime',
        'revision_start_date' => 'datetime',
        'revision_end_date' => 'datetime',
        'revision_review_start_date' => 'datetime',
        'revision_review_end_date' => 'datetime',
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
        return $now->between($this->upload_start_date, $this->laporan_akhir_review_end_date ?? $this->review_end_date);
    }

    /**
     * Get status of timeline based on current stage
     */
    public function getStatus()
    {
        $now = Carbon::now();
        
        $revisionStart = $this->revision_start_date ?? $this->revisi_proposal_start_date;
        $revisionEnd = $this->revision_end_date ?? $this->revisi_proposal_end_date;
        $revisionReviewStart = $this->revision_review_start_date ?? $this->revisi_proposal_review_start_date;
        $revisionReviewEnd = $this->revision_review_end_date ?? $this->revisi_proposal_review_end_date;

        // Check each stage in order
        if ($now->lt($this->upload_start_date)) {
            return 'upcoming';
        } elseif ($now->between($this->upload_start_date, $this->upload_end_date)) {
            return 'upload_proposal';
        } elseif ($now->between($this->review_start_date, $this->review_end_date)) {
            return 'review_proposal';
        } elseif ($revisionStart && $revisionEnd && $now->between($revisionStart, $revisionEnd)) {
            return 'revisi_proposal';
        } elseif ($revisionReviewStart && $revisionReviewEnd && $now->between($revisionReviewStart, $revisionReviewEnd)) {
            return 'review_revisi_proposal';
        } elseif ($this->laporan_kemajuan_start_date && $now->between($this->laporan_kemajuan_start_date, $this->laporan_kemajuan_end_date)) {
            return 'upload_laporan_kemajuan';
        } elseif ($this->laporan_kemajuan_review_start_date && $now->between($this->laporan_kemajuan_review_start_date, $this->laporan_kemajuan_review_end_date)) {
            return 'review_laporan_kemajuan';
        } elseif ($this->laporan_akhir_start_date && $now->between($this->laporan_akhir_start_date, $this->laporan_akhir_end_date)) {
            return 'upload_laporan_akhir';
        } elseif ($this->laporan_akhir_review_start_date && $now->between($this->laporan_akhir_review_start_date, $this->laporan_akhir_review_end_date)) {
            return 'review_laporan_akhir';
        } elseif ($this->laporan_akhir_review_end_date && $now->gt($this->laporan_akhir_review_end_date)) {
            return 'completed';
        } else {
            return 'completed';
        }
    }

    /**
     * Get current active stage
     */
    public function getCurrentStage()
    {
        $status = $this->getStatus();
        return match($status) {
            'upload_proposal' => 'Upload Proposal',
            'review_proposal' => 'Review Proposal',
            'revisi_proposal' => 'Revisi Proposal',
            'review_revisi_proposal' => 'Review Revisi Proposal',
            'upload_laporan_kemajuan' => 'Upload Laporan Kemajuan',
            'review_laporan_kemajuan' => 'Review Laporan Kemajuan',
            'upload_laporan_akhir' => 'Upload Laporan Akhir',
            'review_laporan_akhir' => 'Review Laporan Akhir',
            'completed' => 'Selesai',
            'upcoming' => 'Akan Dimulai',
            default => 'Unknown',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabel()
    {
        return $this->getCurrentStage();
    }

    /**
     * Get status color
     */
    public function getStatusColor()
    {
        $status = $this->getStatus();
        
        return match($status) {
            'upcoming' => 'info',
            'upload_proposal', 'upload_laporan_kemajuan', 'upload_laporan_akhir' => 'primary',
            'review_proposal', 'review_laporan_kemajuan', 'review_laporan_akhir', 'review_revisi_proposal' => 'warning',
            'revisi_proposal' => 'secondary',
            'completed' => 'success',
            default => 'secondary',
        };
    }

    /**
     * Check if a specific stage is currently active
     */
    public function isStageActive($stage)
    {
        $now = Carbon::now();
        
        return match($stage) {
            'upload_proposal' => $now->between($this->upload_start_date, $this->upload_end_date),
            'review_proposal' => $now->between($this->review_start_date, $this->review_end_date),
            'revisi_proposal' => ($this->revision_start_date ?? $this->revisi_proposal_start_date) && ($this->revision_end_date ?? $this->revisi_proposal_end_date) && $now->between($this->revision_start_date ?? $this->revisi_proposal_start_date, $this->revision_end_date ?? $this->revisi_proposal_end_date),
            'review_revisi_proposal' => ($this->revision_review_start_date ?? $this->revisi_proposal_review_start_date) && ($this->revision_review_end_date ?? $this->revisi_proposal_review_end_date) && $now->between($this->revision_review_start_date ?? $this->revisi_proposal_review_start_date, $this->revision_review_end_date ?? $this->revisi_proposal_review_end_date),
            'laporan_kemajuan' => $this->laporan_kemajuan_start_date && $this->laporan_kemajuan_end_date && $now->between($this->laporan_kemajuan_start_date, $this->laporan_kemajuan_end_date),
            'laporan_akhir' => $this->laporan_akhir_start_date && $this->laporan_akhir_end_date && $now->between($this->laporan_akhir_start_date, $this->laporan_akhir_end_date),
            default => false,
        };
    }
}

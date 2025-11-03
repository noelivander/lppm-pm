<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Agenda extends Model
{
    use HasFactory;
    
    protected $table = 'agendas';

    protected $fillable = [
        'user_id', 'tag', 'judul', 'lokasi', 'slug', 'jadwal', 'jadwal_akhir', 
        'deskripsi', 'deskripsi_singkat', 'is_shown', 'tautan', 'cover'
    ];

    protected $dates = [
        'jadwal',
        'jadwal_akhir',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'is_shown' => 'boolean',
        'jadwal' => 'datetime',
        'jadwal_akhir' => 'datetime',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Generate slug automatically when creating a new agenda
        static::creating(function ($agenda) {
            if (empty($agenda->slug)) {
                $agenda->slug = Str::slug($agenda->judul);
                
                // Make sure the slug is unique
                $originalSlug = $slug = $agenda->slug;
                $count = 1;
                
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }
                
                $agenda->slug = $slug;
            }

            // Set default user if not set
            if (empty($agenda->user_id) && auth()->check()) {
                $agenda->user_id = auth()->id();
            }
        });
    }

    /**
     * Get the user that owns the agenda.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include upcoming events.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('jadwal', '>=', now())
                    ->where('is_shown', true)
                    ->orderBy('jadwal', 'asc');
    }

    /**
     * Scope a query to only include past events.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePast($query)
    {
        return $query->where('jadwal', '<', now())
                    ->where('is_shown', true)
                    ->orderBy('jadwal', 'desc');
    }

    /**
     * Scope a query to only include active (shown) events.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_shown', true);
    }

    /**
     * Scope a query to get latest events.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTerbaru($query, $limit = 3)
    {
        return $query->select(['id', 'judul', 'slug', 'jadwal', 'jadwal_akhir', 'lokasi', 'tag', 'cover'])
                    ->where('is_shown', true)
                    ->where('jadwal', '>=', now())
                    ->orderBy('jadwal', 'asc')
                    ->take($limit);
    }

    /**
     * Get the event's formatted date.
     *
     * @return string
     */
    public function getFormattedDateAttribute()
    {
        $startDate = Carbon::parse($this->jadwal);
        
        if ($this->jadwal_akhir) {
            $endDate = Carbon::parse($this->jadwal_akhir);
            
            if ($startDate->isSameDay($endDate)) {
                return $startDate->translatedFormat('l, d F Y');
            }
            
            if ($startDate->isSameMonth($endDate, 'month')) {
                return $startDate->translatedFormat('d') . ' - ' . $endDate->translatedFormat('d F Y');
            }
            
            if ($startDate->isSameYear($endDate, 'year')) {
                return $startDate->translatedFormat('d M') . ' - ' . $endDate->translatedFormat('d M Y');
            }
            
            return $startDate->translatedFormat('d M Y') . ' - ' . $endDate->translatedFormat('d M Y');
        }
        
        return $startDate->translatedFormat('l, d F Y');
    }

    /**
     * Get the event's time range.
     *
     * @return string
     */
    public function getTimeRangeAttribute()
    {
        $start = Carbon::parse($this->jadwal);
        
        if ($this->jadwal_akhir) {
            $end = Carbon::parse($this->jadwal_akhir);
            return $start->format('H:i') . ' - ' . $end->format('H:i');
        }
        
        return $start->format('H:i');
    }

    /**
     * Get the URL to the event's cover image.
     *
     * @return string
     */
    public function getCoverUrlAttribute()
    {
        if ($this->cover) {
            return asset('storage/' . ltrim($this->cover, '/'));
        }
        
        return asset('images/default-cover.jpg');
    }
}

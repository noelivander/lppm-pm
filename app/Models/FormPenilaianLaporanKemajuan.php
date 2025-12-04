<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPenilaianLaporanKemajuan extends Model
{
    use HasFactory;

    protected $table = 'form_penilaian_laporan_kemajuan';

    protected $fillable = [
        'jenis',
        'kategori',
        'komponen_penilaian',
        'urutan',
        'is_active',
    ];

    public function subKomponen()
    {
        return $this->hasMany(FormPenilaianLaporanKemajuanSub::class, 'form_penilaian_id')->orderBy('urutan');
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
     * Check if this form has been used in any laporan kemajuan
     * 
     * @return bool
     */
    public function hasBeenUsed()
    {
        // Check if any laporan kemajuan was created after this form was created
        // This is a simple check - in a real scenario, you might want to check
        // if there's a direct relationship or snapshot
        $laporanKemajuan = \App\Models\LaporanKemajuan::where('created_at', '>=', $this->created_at)
            ->where(function($query) {
                if ($this->jenis === 'penelitian') {
                    $query->whereNotNull('penelitian_id');
                } else {
                    $query->whereNotNull('pengabdian_id');
                }
            })
            ->exists();
            
        return $laporanKemajuan;
    }
}

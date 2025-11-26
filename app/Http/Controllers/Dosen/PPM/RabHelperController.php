<?php

namespace App\Http\Controllers\Dosen\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KomponenRab;

class RabHelperController extends Controller
{
    /**
     * Get satuan for a komponen (by komponen name)
     * Used in create forms for dynamic satuan dropdown
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSatuanByKomponenName(Request $request)
    {
        try {
            $komponenName = $request->input('komponen');
            
            if (!$komponenName) {
                return response()->json([
                    'error' => 'Komponen name is required'
                ], 400);
            }

            // Find komponen by name
            $komponen = KomponenRab::where('nama', $komponenName)
                ->where('is_active', true)
                ->with('satuan', function($query) {
                    $query->where('is_active', true);
                })
                ->first();

            if (!$komponen) {
                return response()->json([
                    'satuan' => []
                ]);
            }

            $satuan = $komponen->satuan->map(function($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'singkatan' => $item->singkatan,
                ];
            });

            return response()->json([
                'satuan' => $satuan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}


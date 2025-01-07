<?php
namespace App\Http\Controllers\Reviewer\PPM;

use Mpdf\Mpdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penelitian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\Review;
use Illuminate\Support\Facades\Log;
use App\Helpers\EncryptionHelper; 
use Illuminate\Support\Facades\Storage;


class PenelitianController extends Controller
{
    public function index()
    {
        $proposals = Penelitian::all();
        $reviews = Review::where('reviewer_id', auth()->id())->pluck('penelitian_id')->toArray();
        $existingReviews = Review::all(); 

        foreach ($proposals as $proposal) {
            try {
                $proposal->judul = EncryptionHelper::decrypt($proposal->judul);
            } catch (\Exception $e) {
                $proposal->judul = null;
            }

            try {
                $proposal->skema = EncryptionHelper::decrypt($proposal->skema);
            } catch (\Exception $e) {
                $proposal->skema = null;
            }
        }
        
        return view('reviewer.ppm.penelitian.index', compact('proposals', 'reviews', 'existingReviews'));
    }

    public function review($id)
    {
        $proposal = Penelitian::findOrFail($id);
        $review = Review::where('penelitian_id', $id)->where('reviewer_id', Auth::id())->first();
        
        $ketuaTim = Anggota::where('penelitian_id', $id)
                            ->where('peran', 'ketua')
                            ->first();
        
        $anggotaTim = Anggota::where('penelitian_id', $id)
                            ->where('peran', 'anggota')
                            ->get();
        
        $ketuaTimName = $ketuaTim ? EncryptionHelper::decrypt($ketuaTim->nama) : '';
        $nidn = $ketuaTim ? EncryptionHelper::decrypt($ketuaTim->nidn) : '';
        $jabatan = $ketuaTim ? EncryptionHelper::decrypt($ketuaTim->jabatan) : '';
        
        $anggotaNames = $anggotaTim->map(function($anggota) {
            return EncryptionHelper::decrypt($anggota->nama);
        })->join(', ');
        
        $judul = EncryptionHelper::decrypt($proposal->judul);
        $biayaUsulan = EncryptionHelper::decrypt($proposal->biaya_diusulkan); 
        $sintaIndex = EncryptionHelper::decrypt($proposal->sinta_index);

        $encryptedFilePath = $proposal->dokumen_proposal;

        $decryptedContent = EncryptionHelper::decryptFile($encryptedFilePath);

        // Simpan file sementara di public/temp
        $fileName = 'temp/decrypted_' . uniqid() . '.pdf';
        Storage::disk('public')->put($fileName, $decryptedContent);

        // Buat URL publik
        $decryptedFileUrl = asset('storage/' . $fileName);

        if ($review) {
            return view('reviewer.ppm.penelitian.edit_review', compact('proposal', 'review', 'ketuaTimName', 'decryptedFileUrl', 'nidn', 'anggotaNames', 'jabatan', 'judul', 'biayaUsulan', 'sintaIndex'));
        } else {
            return view('reviewer.ppm.penelitian.review', compact('proposal', 'ketuaTimName', 'nidn', 'decryptedFileUrl', 'anggotaNames', 'jabatan', 'judul', 'biayaUsulan', 'sintaIndex'));
        }
    }
    

    public function view_pdf($penelitian_id)
    {
        $review = Review::where('penelitian_id', $penelitian_id)
                        ->where('reviewer_id', auth()->id()) // Pastikan reviewer yang login yang sesuai
                        ->first();
    
        if (!$review) {
  
            return redirect()->route('penelitian-rev.index')->with('error', 'Review tidak ditemukan atau Anda tidak memiliki akses.');
        }
    
        $html = view('pdf.review_template', compact('review'))->render();
    
        $mpdf = new \Mpdf\Mpdf([ 
            'format' => [215.9, 330.2],  
            'margin_left' => 25.4, 
            'margin_right' => 25.4, 
            'margin_top' => 25.4, 
            'margin_bottom' => 25.4,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function store(Request $request)
    {
        $review = new Review();

        $review->penelitian_id = $request->penelitian_id;
        $review->reviewer_id = auth()->id();
        $review->reviewer_name = auth()->user()->name;
        $review->judul_kegiatan = $request->judul_kegiatan;
        $review->ketua_tim = $request->ketua_tim;
        $review->nidn = $request->nidn;
        $review->jabatan = $request->jabatan;
        $review->scopus = $request->scopus;
        $review->anggota = $request->anggota;
        $review->biaya_usulan = $request->biaya_usulan;
        $review->disarankan = $request->disarankan;

        $review->skor_1 = $request->skor_1;
        $review->skor_2 = $request->skor_2;
        $review->skor_3 = $request->skor_3;
        $review->skor_4 = $request->skor_4;
        $review->skor_5 = $request->skor_5;

        $review->komentar = $request->komentar;
        $review->save();

        $penelitian = Penelitian::findOrFail($request->penelitian_id);
        $totalReviews = Review::where('penelitian_id', $penelitian->id)->count();

        if ($totalReviews == 1) {
            $penelitian->status = 'Diproses';
        } elseif ($totalReviews >= 2) {
            $penelitian->status = 'Selesai';
        }
        $penelitian->save();

        return redirect()->route('penelitian-rev.index')->with('status', 'Review berhasil disubmit!');
    }

    public function updateReview(Request $request, $id)
    {
        $validatedData = $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'ketua_tim' => 'required|string|max:255',
            'nidn' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'scopus' => 'nullable|string|max:255',
            'anggota' => 'required|string|max:255',
            'biaya_usulan' => 'required|numeric',
            'disarankan' => 'nullable|string|max:255',
            'skor_1' => 'required|integer|min:1|max:7',
            'skor_2' => 'required|integer|min:1|max:7',
            'skor_3' => 'required|integer|min:1|max:7',
            'skor_4' => 'required|integer|min:1|max:7',
            'skor_5' => 'required|integer|min:1|max:7',
            'komentar' => 'nullable|string',
        ]);

        $review = Review::findOrFail($id);

        $review->update($validatedData);

        $penelitian = Penelitian::findOrFail($review->penelitian_id);
        $totalReviews = Review::where('penelitian_id', $penelitian->id)->count();

        if ($totalReviews == 1) {
            $penelitian->status = 'Diproses';
        } elseif ($totalReviews >= 2) {
            $penelitian->status = 'Selesai';
        }
        $penelitian->save();

        return redirect()->route('penelitian-rev.index')->with('success', 'Review berhasil diperbarui.');
    }

    public function editReview($id)
    {
        $proposal = Penelitian::findOrFail($id);
        $review = Review::where('penelitian_id', $id)->where('reviewer_id', Auth::id())->first();

        $ketuaTim = Anggota::where('penelitian_id', $id)
            ->where('peran', 'ketua')
            ->first();

        $anggotaTim = Anggota::where('penelitian_id', $id)
                ->where('peran', 'anggota')
                ->get();

        $ketuaTimName = $ketuaTim ? EncryptionHelper::decrypt($ketuaTim->nama) : '';
        $nidn = $ketuaTim ? EncryptionHelper::decrypt($ketuaTim->nidn) : '';
        $jabatan = $ketuaTim ? EncryptionHelper::decrypt($ketuaTim->jabatan) : '';
        
        $anggotaNames = $anggotaTim->map(function($anggota) {
            return EncryptionHelper::decrypt($anggota->nama);
        })->join(', ');

        $judul = EncryptionHelper::decrypt($proposal->judul);
        $biayaUsulan = EncryptionHelper::decrypt($proposal->biaya_diusulkan); 
        $sintaIndex = EncryptionHelper::decrypt($proposal->sinta_index);

        $encryptedFilePath = $proposal->dokumen_proposal;

        $decryptedContent = EncryptionHelper::decryptFile($encryptedFilePath);

        // Simpan file sementara di public/temp
        $fileName = 'temp/decrypted_' . uniqid() . '.pdf';
        Storage::disk('public')->put($fileName, $decryptedContent);

        // Buat URL publik
        $decryptedFileUrl = asset('storage/' . $fileName);

        if ($review) {
            return view('reviewer.ppm.penelitian.edit_review', compact('proposal', 'review', 'decryptedFileUrl', 'judul', 'ketuaTimName', 'nidn', 'anggotaNames', 'jabatan', 'biayaUsulan', 'sintaIndex'));
        } else {
            return redirect()->back()->with('error', 'Review not found.');
        }
    }
}

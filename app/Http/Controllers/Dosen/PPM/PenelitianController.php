<?php
namespace App\Http\Controllers\Dosen\PPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penelitian;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\RabPenelitian;
use App\Models\Review;
use Mpdf\Mpdf;
use App\Helpers\EncryptionHelper;
use App\Models\Timeline;
use App\Models\PPM\Skema;
use App\Models\PPM\Luaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PenelitianController extends Controller
{

    public function index()
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();
        $penelitian = Penelitian::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        foreach ($penelitian as $item) {
            $item->judul = EncryptionHelper::decrypt($item->judul);
            $item->luaran_wajib = EncryptionHelper::decrypt($item->luaran_wajib);
            $item->sinta_index = EncryptionHelper::decrypt($item->sinta_index);
            $item->lama_penelitian = EncryptionHelper::decrypt($item->lama_penelitian);
            $item->biaya_diusulkan = EncryptionHelper::decrypt($item->biaya_diusulkan);
            $item->skema = EncryptionHelper::decrypt($item->skema);
            $item->luaran_tambahan = EncryptionHelper::decrypt($item->luaran_tambahan);
            $item->ringkasan_proposal = EncryptionHelper::decrypt($item->ringkasan_proposal);
        }

        return view('dosen.ppm.penelitian.index', compact('penelitian','timeline','currentDate'));
    }

    public function create()
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $skemaPenelitian = Skema::where('jenis', 'penelitian')->where('is_shown', 1)->get();
        $luaranWajibPenelitian = Luaran::where('jenis', 'penelitian')->where('kategori', 'wajib')->where('is_shown', 1)->get();
        $luaranTambahanPenelitian = Luaran::where('jenis', 'penelitian')->where('kategori', 'tambahan')->where('is_shown', 1)->get();

        // Get RAB data from database
        $kelompokRab = \App\Models\KelompokRab::where('is_active', true)->orderBy('nama')->get();
        $komponenRab = \App\Models\KomponenRab::with('satuan')->where('is_active', true)->orderBy('nama')->get();
        $satuanRab = \App\Models\SatuanRab::where('is_active', true)->orderBy('nama')->get();

        return view('dosen.ppm.penelitian.create', compact(
            'timeline',
            'currentDate',
            'skemaPenelitian',
            'luaranWajibPenelitian',
            'luaranTambahanPenelitian',
            'kelompokRab',
            'komponenRab',
            'satuanRab'
        ));
    }

    public function viewReviews($penelitian_id, $review_number)
    {
        $penelitian = Penelitian::findOrFail($penelitian_id);

        $reviews = Review::where('penelitian_id', $penelitian_id)->get();

        if ($review_number == 1) {
            $review = $reviews->first();
        } elseif ($review_number == 2) {
            $review = $reviews->skip(1)->first(); 
        } else {
            return redirect()->route('penelitian-dos.index')
                            ->with('error', 'Nomor review tidak valid.');
        }

        $html = view('pdf.review_template', compact('penelitian', 'review'))->render();
        
        $mpdf = new \Mpdf\Mpdf(['format' => [215.9, 330.2]]);  // Format F4
        $mpdf->WriteHTML($html);
        $mpdf->Output("Hasil_Review_{$penelitian->judul}_Review{$review_number}.pdf", 'I');  // Output PDF
    }

    public function store(Request $request)
    {
        try {
            $currentDate = now();
            $timeline = $this->getActiveTimeline();
        
            if (!$timeline) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Belum ada timeline aktif.');
            }

            if ($currentDate < $timeline->upload_start_date || $currentDate > $timeline->upload_end_date) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Anda tidak dapat mengunggah proposal di luar periode yang ditentukan.');
            }

            // Validation rules
            $validatedData = $request->validate([
                'judul' => 'required|string|max:255',
                'luaran_wajib' => 'required|string',
                'lama_penelitian' => 'required|string',
                'biaya_diusulkan' => 'required|string',
                'skema' => 'required|string',
                'luaran_tambahan' => 'nullable|string',
                'ringkasan_proposal' => 'required|string',
                'dokumen_proposal' => 'required|mimes:pdf|max:10000',
                'sinta_index' => 'nullable|string',
                'anggota_nama' => 'required|array|min:1',
                'anggota_nama.*' => 'required|string',
                'anggota_peran' => 'required|array|min:1',
                'anggota_peran.*' => 'required|string|in:Ketua,Anggota',
                'anggota_nidn' => 'required|array|min:1',
                'anggota_nidn.*' => 'required|string',
                'anggota_jabatan' => 'required|array|min:1',
                'anggota_jabatan.*' => 'required|string|in:Dosen,Mahasiswa',
                'anggota_email' => 'required|array|min:1',
                'anggota_email.*' => 'required|email',
                'anggota_telepon' => 'required|array|min:1',
                'anggota_telepon.*' => 'required|string',
                // RAB validation
                'rab_kelompok' => 'required|array|min:1',
                'rab_kelompok.*' => 'required|string|in:Honorarium,Perjalanan,Operasional,Peralatan,Lainnya',
                'rab_komponen' => 'required|array|min:1',
                'rab_komponen.*' => 'required|string|in:SDM,Material,Jasa,Transportasi,Lainnya',
                'rab_item' => 'required|array|min:1',
                'rab_item.*' => 'required|string|max:255',
                'rab_satuan' => 'required|array|min:1',
                'rab_satuan.*' => 'required|string|max:50',
                'rab_volume' => 'required|array|min:1',
                'rab_volume.*' => 'required|integer|min:1',
                'rab_harga_satuan' => 'required|array|min:1',
                'rab_harga_satuan.*' => 'required|numeric|min:0',
                'rab_total' => 'required|array|min:1',
                'rab_total.*' => 'required|numeric|min:0',
                'rab_total_anggaran' => 'nullable|numeric|min:0',
            ], [
                'rab_kelompok.required' => 'Minimal satu baris RAB harus diisi.',
                'rab_kelompok.*.required' => 'Kelompok RAB harus dipilih.',
                'rab_komponen.*.required' => 'Komponen RAB harus dipilih.',
                'rab_item.*.required' => 'Item RAB harus diisi.',
                'rab_volume.*.required' => 'Volume RAB harus diisi.',
                'rab_volume.*.integer' => 'Volume harus berupa angka.',
                'rab_volume.*.min' => 'Volume minimal 1.',
                'rab_harga_satuan.*.required' => 'Harga satuan RAB harus diisi.',
                'rab_harga_satuan.*.numeric' => 'Harga satuan harus berupa angka.',
                'rab_harga_satuan.*.min' => 'Harga satuan minimal 0.',
            ]);

            // Store file with error handling
            if (!$request->hasFile('dokumen_proposal')) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Dokumen proposal wajib diunggah.');
            }

            $dokumenProposal = $request->file('dokumen_proposal')->store('public/proposals');
            if (!$dokumenProposal) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengunggah dokumen proposal. Silakan coba lagi.');
            }

            $encryptedDokumenProposal = EncryptionHelper::encryptFile($dokumenProposal);

            // Use database transaction for atomic operations
            DB::beginTransaction();

            try {
                // Create penelitian
                $penelitian = Penelitian::create([
                    'judul' => EncryptionHelper::encrypt($request->judul),
                    'luaran_wajib' => EncryptionHelper::encrypt($request->luaran_wajib),
                    'sinta_index' => EncryptionHelper::encrypt($request->sinta_index ?? ''),
                    'lama_penelitian' => EncryptionHelper::encrypt($request->lama_penelitian),
                    'biaya_diusulkan' => EncryptionHelper::encrypt($request->biaya_diusulkan),
                    'skema' => EncryptionHelper::encrypt($request->skema),
                    'luaran_tambahan' => EncryptionHelper::encrypt($request->luaran_tambahan ?? ''),
                    'ringkasan_proposal' => EncryptionHelper::encrypt($request->ringkasan_proposal),
                    'dokumen_proposal' => $encryptedDokumenProposal,
                    'status' => 'Pending',
                    'user_id' => Auth::id(),
                ]);

                if (!$penelitian) {
                    throw new \Exception('Gagal membuat penelitian.');
                }

                // Create anggota
                if (isset($request->anggota_nama) && is_array($request->anggota_nama)) {
                    foreach ($request->anggota_nama as $key => $nama) {
                        if (empty($nama)) {
                            continue;
                        }

                        Anggota::create([
                            'penelitian_id' => $penelitian->id,
                            'nama' => EncryptionHelper::encrypt($nama),
                            'jabatan' => EncryptionHelper::encrypt($request->anggota_jabatan[$key] ?? ''),
                            'peran' => $request->anggota_peran[$key] ?? 'Anggota',
                            'nidn' => EncryptionHelper::encrypt($request->anggota_nidn[$key] ?? ''),
                            'email' => EncryptionHelper::encrypt($request->anggota_email[$key] ?? ''),
                            'telepon' => EncryptionHelper::encrypt($request->anggota_telepon[$key] ?? ''),
                        ]);
                    }
                }

                // Create RAB items
                if (isset($request->rab_kelompok) && is_array($request->rab_kelompok)) {
                    foreach ($request->rab_kelompok as $key => $kelompok) {
                        if (empty($kelompok)) {
                            continue;
                        }

                        $volume = (int) ($request->rab_volume[$key] ?? 0);
                        $hargaSatuan = (float) ($request->rab_harga_satuan[$key] ?? 0);
                        $total = (float) ($request->rab_total[$key] ?? 0);

                        // Validate and calculate total
                        $calculatedTotal = $volume * $hargaSatuan;
                        if (abs($calculatedTotal - $total) > 0.01) {
                            Log::warning('RAB total mismatch', [
                                'key' => $key,
                                'calculated' => $calculatedTotal,
                                'submitted' => $total
                            ]);
                            // Use calculated total for accuracy
                            $total = $calculatedTotal;
                        }

                        RabPenelitian::create([
                            'penelitian_id' => $penelitian->id,
                            'kelompok' => $kelompok,
                            'komponen' => $request->rab_komponen[$key] ?? '',
                            'item' => $request->rab_item[$key] ?? '',
                            'satuan' => $request->rab_satuan[$key] ?? '',
                            'volume' => $volume,
                            'harga_satuan' => $hargaSatuan,
                            'total' => $total,
                        ]);
                    }
                } else {
                    throw new \Exception('Data RAB tidak ditemukan. Minimal satu baris RAB harus diisi.');
                }

                DB::commit();

                return redirect()->route('penelitian-dos.index')
                    ->with('success', 'Proposal penelitian berhasil diajukan.');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error creating penelitian: ' . $e->getMessage(), [
                    'user_id' => Auth::id(),
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                // Clean up uploaded file on error
                if (isset($dokumenProposal) && Storage::exists($dokumenProposal)) {
                    Storage::delete($dokumenProposal);
                }

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected error in PenelitianController@store: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan tidak terduga. Silakan coba lagi atau hubungi administrator.');
        }
    }

    public function downloadDokumenProposal($id)
    {
        $penelitian = Penelitian::findOrFail($id);
        $encryptedFilePath = $penelitian->dokumen_proposal;

        $decryptedContent = EncryptionHelper::decryptFile($encryptedFilePath);

        return response($decryptedContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="proposal.pdf"');
    }


    protected function getActiveTimeline()
    {
        return Timeline::active()
            ->orderBy('period', 'desc')
            ->ordered()
            ->first();
    }
}

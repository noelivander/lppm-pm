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
use App\Models\Timeline;
use App\Models\PPM\Skema;
use App\Models\PPM\Luaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PenelitianController extends Controller
{

    public function index(Request $request)
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        $baseQuery = Penelitian::where('user_id', Auth::id())
            ->where('is_draft', false);

        $filterSkemas = (clone $baseQuery)->select('skema')
            ->whereNotNull('skema')
            ->distinct()
            ->orderBy('skema')
            ->pluck('skema');

        $filterYears = (clone $baseQuery)->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $statuses = ['Pending', 'Diproses', 'Selesai'];

        if ($search = $request->get('search')) {
            $baseQuery->where('judul', 'like', '%' . $search . '%');
        }

        if ($status = $request->get('status')) {
            $baseQuery->where('status', $status);
        }

        if ($skema = $request->get('skema')) {
            $baseQuery->where('skema', $skema);
        }

        if ($year = $request->get('year')) {
            $baseQuery->whereYear('created_at', $year);
        }

        $penelitian = $baseQuery->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        // Cek apakah ada draft
        $draft = Penelitian::where('user_id', Auth::id())
            ->where('is_draft', true)
            ->first();

        // Data sudah tidak dienkripsi, tidak perlu dekripsi

        $filters = $request->only(['search', 'status', 'skema', 'year']);

        return view('dosen.ppm.penelitian.index', compact(
            'penelitian',
            'timeline',
            'currentDate',
            'draft',
            'filterSkemas',
            'filterYears',
            'statuses',
            'filters'
        ));
    }

    public function create()
    {
        $currentDate = now();
        $timeline = $this->getActiveTimeline();

        // Cek apakah ada draft
        $draft = Penelitian::where('user_id', Auth::id())
            ->where('is_draft', true)
            ->with(['anggota', 'rab'])
            ->first();

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
            'satuanRab',
            'draft'
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
            
            $isDraft = $request->has('save_as_draft') && $request->save_as_draft == '1';
        
            // Check if existing draft has dokumen_proposal for submit (non-draft)
            $hasExistingDokumen = false;
            if (!$isDraft) {
                $checkDraft = Penelitian::where('user_id', Auth::id())
                    ->where('is_draft', true)
                    ->first();
                $hasExistingDokumen = $checkDraft && $checkDraft->dokumen_proposal;
            }
        
            // Untuk draft, validasi lebih ringan
            if (!$isDraft) {
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
            }

            // Validation rules - lebih ringan untuk draft
            $validationRules = [
                'judul' => 'required|string|max:255',
                'luaran_wajib' => 'required|string',
                'lama_penelitian' => 'required|string',
                'biaya_diusulkan' => 'required|string',
                'skema' => 'required|string',
                'luaran_tambahan' => 'nullable|string',
                'ringkasan_proposal' => 'required|string',
                'dokumen_proposal' => ($isDraft || $hasExistingDokumen) ? 'nullable|mimes:pdf|max:10000' : 'required|mimes:pdf|max:10000',
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
            ];
            
            // Untuk draft, beberapa field tidak wajib
            if ($isDraft) {
                $validationRules['judul'] = 'nullable|string|max:255';
                $validationRules['luaran_wajib'] = 'nullable|string';
                $validationRules['lama_penelitian'] = 'nullable|string';
                $validationRules['biaya_diusulkan'] = 'nullable|string';
                $validationRules['skema'] = 'nullable|string';
                $validationRules['ringkasan_proposal'] = 'nullable|string';
                $validationRules['anggota_nama'] = 'nullable|array';
                $validationRules['anggota_nama.*'] = 'nullable|string';
                $validationRules['anggota_peran'] = 'nullable|array';
                $validationRules['anggota_peran.*'] = 'nullable|string|in:Ketua,Anggota';
                $validationRules['anggota_nidn'] = 'nullable|array';
                $validationRules['anggota_nidn.*'] = 'nullable|string';
                $validationRules['anggota_jabatan'] = 'nullable|array';
                $validationRules['anggota_jabatan.*'] = 'nullable|string|in:Dosen,Mahasiswa';
                $validationRules['anggota_email'] = 'nullable|array';
                $validationRules['anggota_email.*'] = 'nullable|email';
                $validationRules['anggota_telepon'] = 'nullable|array';
                $validationRules['anggota_telepon.*'] = 'nullable|string';
                $validationRules['rab_kelompok'] = 'nullable|array';
                $validationRules['rab_kelompok.*'] = 'nullable|string|in:Honorarium,Perjalanan,Operasional,Peralatan,Lainnya';
                $validationRules['rab_komponen'] = 'nullable|array';
                $validationRules['rab_komponen.*'] = 'nullable|string|in:SDM,Material,Jasa,Transportasi,Lainnya';
                $validationRules['rab_item'] = 'nullable|array';
                $validationRules['rab_item.*'] = 'nullable|string|max:255';
                $validationRules['rab_satuan'] = 'nullable|array';
                $validationRules['rab_satuan.*'] = 'nullable|string|max:50';
                $validationRules['rab_volume'] = 'nullable|array';
                $validationRules['rab_volume.*'] = 'nullable|integer';
                $validationRules['rab_harga_satuan'] = 'nullable|array';
                $validationRules['rab_harga_satuan.*'] = 'nullable|numeric|min:0';
                $validationRules['rab_total'] = 'nullable|array';
                $validationRules['rab_total.*'] = 'nullable|numeric|min:0';
            }
            
            $validatedData = $request->validate($validationRules, [
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
            $dokumenProposal = null;
            if ($request->hasFile('dokumen_proposal')) {
                $dokumenProposal = $request->file('dokumen_proposal')->store('public/proposals');
                if (!$dokumenProposal) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal mengunggah dokumen proposal. Silakan coba lagi.');
                }
            } elseif (!$isDraft) {
                // Check if existing draft has dokumen_proposal
                $existingDraft = Penelitian::where('user_id', Auth::id())
                    ->where('is_draft', true)
                    ->first();
                
                if (!$existingDraft || !$existingDraft->dokumen_proposal) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Dokumen proposal wajib diunggah.');
                }
            }

            // Use database transaction for atomic operations
            DB::beginTransaction();

            try {
                // Cek apakah ada draft yang akan diupdate
                $existingDraft = Penelitian::where('user_id', Auth::id())
                    ->where('is_draft', true)
                    ->first();
                
                $data = [
                    'judul' => $request->judul ?? null,
                    'luaran_wajib' => $request->luaran_wajib ?? null,
                    'sinta_index' => $request->sinta_index ?? null,
                    'lama_penelitian' => $request->lama_penelitian ?? null,
                    'biaya_diusulkan' => !empty($request->biaya_diusulkan) ? $request->biaya_diusulkan : null,
                    'skema' => $request->skema ?? null,
                    'luaran_tambahan' => $request->luaran_tambahan ?? null,
                    'ringkasan_proposal' => $request->ringkasan_proposal ?? null,
                    'is_draft' => $isDraft,
                    'user_id' => Auth::id(),
                ];
                
                if ($dokumenProposal) {
                    $data['dokumen_proposal'] = $dokumenProposal;
                    // Hapus file lama jika ada
                    if ($existingDraft && $existingDraft->dokumen_proposal) {
                        Storage::delete($existingDraft->dokumen_proposal);
                    }
                } elseif ($existingDraft && $existingDraft->dokumen_proposal) {
                    // Keep existing file if no new file uploaded
                    $data['dokumen_proposal'] = $existingDraft->dokumen_proposal;
                } else {
                    // Allow null for draft
                    $data['dokumen_proposal'] = null;
                }
                
                if (!$isDraft) {
                    $data['status'] = 'Pending';
                }
                
                if ($existingDraft) {
                    // Update draft yang ada
                    $penelitian = $existingDraft;
                    $penelitian->update($data);
                    
                    // Hapus anggota dan RAB lama
                    Anggota::where('penelitian_id', $penelitian->id)->delete();
                    RabPenelitian::where('penelitian_id', $penelitian->id)->delete();
                } else {
                    // Create baru
                    $penelitian = Penelitian::create($data);
                }

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
                            'nama' => $nama,
                            'jabatan' => !empty($request->anggota_jabatan[$key]) ? $request->anggota_jabatan[$key] : null,
                            'peran' => !empty($request->anggota_peran[$key]) ? $request->anggota_peran[$key] : 'Anggota',
                            'nidn' => !empty($request->anggota_nidn[$key]) ? $request->anggota_nidn[$key] : null,
                            'email' => !empty($request->anggota_email[$key]) ? $request->anggota_email[$key] : null,
                            'telepon' => !empty($request->anggota_telepon[$key]) ? $request->anggota_telepon[$key] : null,
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
                            'komponen' => !empty($request->rab_komponen[$key]) ? $request->rab_komponen[$key] : null,
                            'item' => !empty($request->rab_item[$key]) ? $request->rab_item[$key] : null,
                            'satuan' => !empty($request->rab_satuan[$key]) ? $request->rab_satuan[$key] : null,
                            'volume' => $volume > 0 ? $volume : null,
                            'harga_satuan' => $hargaSatuan > 0 ? $hargaSatuan : null,
                            'total' => $total > 0 ? $total : null,
                        ]);
                    }
                } elseif (!$isDraft) {
                    throw new \Exception('Data RAB tidak ditemukan. Minimal satu baris RAB harus diisi.');
                }

                DB::commit();

                if ($isDraft) {
                    return redirect()->route('penelitian-dos.index')
                        ->with('success', 'Draft berhasil disimpan.');
                } else {
                    return redirect()->route('penelitian-dos.index')
                        ->with('success', 'Proposal penelitian berhasil diajukan.');
                }

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
        $filePath = $penelitian->dokumen_proposal;

        if (!Storage::exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::download($filePath, 'proposal.pdf');
    }


    protected function getActiveTimeline()
    {
        return Timeline::active()
            ->orderBy('period', 'desc')
            ->ordered()
            ->first();
    }
}

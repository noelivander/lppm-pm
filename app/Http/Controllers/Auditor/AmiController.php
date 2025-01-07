<?php
namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AmiController extends Controller
{
    /**
     * Display a listing of the resources (e.g., list of audits).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Data untuk ditampilkan di halaman daftar AMI
        $audits = []; // Ganti dengan query ke database
        return view('auditor.ami', compact('audits'));
    }

    /**
     * Show the form for creating a new audit evaluation.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auditor.ami.create'); // Halaman untuk membuat form penilaian
    }

    /**
     * Store a newly created evaluation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'field1' => 'required|string',
            'field2' => 'required|integer',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Simpan ke database
        // Audit::create($validated);

        return redirect()->route('auditor.ami')->with('success', 'Penilaian berhasil disimpan.');
    }

    /**
     * Show the form for editing a specific audit evaluation.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Data audit berdasarkan ID
        $audit = []; // Ganti dengan query ke database
        return view('auditor.ami.edit', compact('audit'));
    }

    public function submit(Request $request)
    {
    $validated = $request->validate([
        'pernyataan_1' => 'required|string',
        'bukti_1' => 'required|file|mimes:jpg,png,pdf',
        'pernyataan_2' => 'required|string',
        'bukti_2' => 'required|file|mimes:jpg,png,pdf',
    ]);

    $filePath1 = $request->file('bukti_1')->store('bukti');
    $filePath2 = $request->file('bukti_2')->store('bukti');
    }


    /**
     * Update the specified evaluation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi dan perbarui data
        $validated = $request->validate([
            'field1' => 'required|string',
            'field2' => 'required|integer',
        ]);

        // Update ke database
        // $audit = Audit::findOrFail($id);
        // $audit->update($validated);

        return redirect()->route('auditor.ami')->with('success', 'Penilaian berhasil diperbarui.');
    }

    /**
     * Remove the specified evaluation from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Hapus data dari database
        // $audit = Audit::findOrFail($id);
        // $audit->delete();

        return redirect()->route('auditor.ami')->with('success', 'Penilaian berhasil dihapus.');
    }
}

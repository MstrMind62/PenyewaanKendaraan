<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use Illuminate\Http\Request;

class ArmadaController extends Controller
{
    public function index(Request $request)
    {
        // Menangkap nilai filter kategori dari dropdown (jika ada)
        $kategori = $request->input('kategori');

        // Memulai query ke database
        $query = Armada::query();

        // Jika kategori dipilih, filter berdasarkan kolom 'tipe'
        if ($kategori) {
            $query->where('tipe', 'ILIKE', '%' . $kategori . '%');
        }

        // Ambil data armada sesuai hasil filter
        $armadas = $query->get();

        // Kirim data armada ke view
        return view('armada.index', compact('armadas'));
    }

    public function create()
    {
        return view('armada.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Sesuaikan field wajib/opsional berikut dengan nama kolom di tabel Rental_kendaraan_armada
            'tipe' => 'nullable|string|max:100',
            'gambar' => 'nullable|url|max:1000',
        ]);

        if (!empty($validated['gambar'])) {
            $validated['gambar'] = $this->formatGoogleDriveUrl($validated['gambar']);
        }

        Armada::create($validated);

        return redirect()->route('armada.index')->with('success', 'Data armada berhasil ditambahkan.');
    }

    private function formatGoogleDriveUrl(string $url): string
    {
        // Format link share standar: https://drive.google.com/file/d/{FILE_ID}/view...
        if (preg_match('~drive\.google\.com/file/d/([a-zA-Z0-9_-]+)~', $url, $matches)) {
            return 'https://drive.google.com/thumbnail?id=' . $matches[1] . '&sz=w1000';
        }

        // Format alternatif: https://drive.google.com/open?id={FILE_ID} atau uc?id={FILE_ID}
        if (preg_match('~[?&]id=([a-zA-Z0-9_-]+)~', $url, $matches)) {
            return 'https://drive.google.com/thumbnail?id=' . $matches[1] . '&sz=w1000';
        }

        return $url;
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Armada;

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
}
<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Sopir;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupirController extends Controller
{
    public function loginForm()
    {
        if (session('role') === 'supir') {
            return redirect()->route('supir.dashboard');
        }

        return view('Supir.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $sopir = Sopir::where('email', $credentials['email'])->first();

        if (
            ! $sopir
            || ! $sopir->password
            || $sopir->status === 'nonaktif'
            || ! Hash::check($credentials['password'], $sopir->password)
        ) {
            return back()
                ->withErrors(['email' => 'Email atau password salah, atau akun tidak aktif.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put([
            'role' => 'supir',
            'sopir_id' => $sopir->id_sopir,
            'user_name' => $sopir->nama,
        ]);

        return redirect()->route('supir.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('supir.login');
    }

    public function dashboard()
    {
        $sopir = $this->authenticatedDriver();
        $orders = $this->assignedOrders($sopir)->latest()->take(5)->get();

        $stats = [
            'total' => $this->assignedOrders($sopir)->count(),
            'menunggu' => $this->assignedOrders($sopir)->where('status', 'Dikonfirmasi')->count(),
            'berjalan' => $this->assignedOrders($sopir)->where('status', 'Dalam Perjalanan')->count(),
            'selesai' => $this->assignedOrders($sopir)->where('status', 'Selesai')->count(),
        ];

        return view('Supir.dashboard', compact('sopir', 'orders', 'stats'));
    }

    public function tasks()
    {
        $sopir = $this->authenticatedDriver();
        $orders = $this->assignedOrders($sopir)->latest()->get();

        return view('Supir.tugas', compact('orders'));
    }

    public function showTask(Pemesanan $p)
    {
        $sopir = $this->authenticatedDriver();
        $this->ensureAssignedTo($p, $sopir);
        $p->load(['customer', 'armada']);

        return view('Supir.detail-tugas', compact('p'));
    }

    public function updateTaskStatus(Request $request, Pemesanan $p)
    {
        $sopir = $this->authenticatedDriver();
        $this->ensureAssignedTo($p, $sopir);

        $data = $request->validate([
            'status' => ['required', 'in:Dalam Perjalanan,Selesai'],
        ]);

        $validTransition = ($p->status === 'Dikonfirmasi' && $data['status'] === 'Dalam Perjalanan')
            || ($p->status === 'Dalam Perjalanan' && $data['status'] === 'Selesai');

        if (! $validTransition) {
            return back()->withErrors(['status' => 'Perubahan status perjalanan tidak valid.']);
        }

        $p->update(['status' => $data['status']]);

        return redirect()
            ->route('supir.tugas.detail', $p)
            ->with('success', 'Status perjalanan berhasil diperbarui.');
    }

    private function authenticatedDriver(): Sopir
    {
        abort_unless(session('role') === 'supir' && session()->has('sopir_id'), 403);

        return Sopir::findOrFail(session('sopir_id'));
    }

    private function assignedOrders(Sopir $sopir): Builder
    {
        return Pemesanan::with(['customer', 'armada'])
            ->where('id_sopir', $sopir->id_sopir);
    }

    private function ensureAssignedTo(Pemesanan $p, Sopir $sopir): void
    {
        abort_unless((int) $p->id_sopir === (int) $sopir->id_sopir, 404);
    }
}

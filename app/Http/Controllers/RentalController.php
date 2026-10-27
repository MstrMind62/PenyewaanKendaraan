<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Armada;
use App\Models\Customer;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Sopir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RentalController extends Controller
{
    public function home()
    {
        $armadas = Armada::where('status_ketersediaan', 'tersedia')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('armadas'));
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $r)
    {
        $d = $r->validate([
            'nama' => 'required|string|max:120',
            'email' => 'required|email|max:150|unique:Rental_kendaraan_customer,email',
            'no_hp' => 'required|string|max:25',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $d['password'] = Hash::make($d['password']);
        $d['status_verifikasi'] = 'belum';

        $c = Customer::create($d);

        session([
            'user_id' => $c->id_customer,
            'user_name' => $c->nama,
            'role' => 'customer',
        ]);

        return redirect()
            ->route('armada.index')
            ->with('success', 'Registrasi berhasil. Akun dibuat dengan status verifikasi belum.');
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $r)
    {
        $d = $r->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($a = Admin::where('email', $d['email'])->first()) {
            if (Hash::check($d['password'], $a->password)) {
                session([
                    'user_id' => $a->id_admin,
                    'user_name' => $a->nama,
                    'role' => 'admin',
                ]);
                $r->session()->regenerate();

                return redirect()->route('admin.dashboard');
            }
        }

        $c = Customer::where('email', $d['email'])->first();

        if (!$c || !Hash::check($d['password'], $c->password)) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        session([
            'user_id' => $c->id_customer,
            'user_name' => $c->nama,
            'role' => 'customer',
        ]);
        $r->session()->regenerate();

        return redirect()
            ->route('armada.index')
            ->with('success', 'Login berhasil.');
    }

    public function logout(Request $r)
    {
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function armadas()
    {
        $armadas = Armada::orderBy('nama_kendaraan')->get();

        return view('armada.index', compact('armadas'));
    }

    public function createBookingForm(Armada $armada)
    {
        abort_unless(session('role') === 'customer', 403);

        return view('pemesanan.create', compact('armada'));
    }

    public function storeBooking(Request $r, Armada $armada)
    {
        abort_unless(session('role') === 'customer', 403);

        $d = $r->validate([
            'tanggal_sewa' => 'required|date|after_or_equal:today',
            'durasi' => 'required|integer|min:1|max:90',
            'layanan' => 'required|in:ambil,diantar',
            'alamat_antar' => 'nullable|required_if:layanan,diantar|string|max:500',
            'metode_pembayaran' => 'required|in:Transfer Bank,E-Wallet,QRIS',
        ]);

        if ($armada->status_ketersediaan !== 'tersedia') {
            return back()->withErrors(['armada' => 'Armada sedang tidak tersedia.']);
        }

        $p = DB::transaction(function () use ($d, $armada) {
            $p = Pemesanan::create([
                'id_customer' => session('user_id'),
                'id_armada' => $armada->id_armada,
                'tanggal_sewa' => $d['tanggal_sewa'],
                'durasi' => $d['durasi'],
                'total_biaya' => $armada->harga_sewa * $d['durasi'],
                'layanan' => $d['layanan'],
                'alamat_antar' => $d['alamat_antar'] ?? null,
                'status' => 'Menunggu Pembayaran',
            ]);

            Pembayaran::create([
                'id_pemesanan' => $p->id_pemesanan,
                'metode_pembayaran' => $d['metode_pembayaran'],
                'status_pembayaran' => 'Menunggu',
            ]);

            return $p;
        });

        return redirect()
            ->route('customer.orders')
            ->with(
                'success',
                'Pemesanan tersimpan. Silakan tunggu verifikasi pembayaran. Nomor pesanan #'
                    . $p->id_pemesanan
            );
    }

    public function customerOrders()
    {
        abort_unless(session('role') === 'customer', 403);

        $orders = Pemesanan::with(['armada', 'sopir', 'pembayaran'])
            ->where('id_customer', session('user_id'))
            ->latest()
            ->get();

        return view('pemesanan.index', compact('orders'));
    }
    // Menampilkan halaman login Admin
    public function adminLoginForm()
    {
        return view('admin.login');
    }

    // Memproses login Admin
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password Admin salah.',
                ])
                ->onlyInput('email');
        }

        // Perbarui ID sesi setelah autentikasi berhasil.
        $request->session()->regenerate();

        // Gunakan session yang sama dengan pemeriksaan di dashboard Admin.
        $request->session()->put([
            'user_id' => $admin->id_admin,
            'user_name' => $admin->nama,
            'role' => 'admin',
        ]);

        return redirect()->route('admin.dashboard');
    }

    // Logout Admin
    public function adminLogout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
    public function cancelBooking(Pemesanan $p)
    {
        abort_unless(
            session('role') === 'customer' && $p->id_customer == session('user_id'),
            403
        );

        if (!in_array($p->status, ['Menunggu Pembayaran', 'Menunggu Konfirmasi'])) {
            return back()->withErrors([
                'status' => 'Pesanan yang sudah diproses tidak dapat dibatalkan.',
            ]);
        }

        $p->update(['status' => 'Dibatalkan']);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function dashboard()
    {
        abort_unless(session('role') === 'admin', 403);

        $stats = [
            'armada' => Armada::count(),
            'customer' => Customer::count(),
            'pesanan' => Pemesanan::count(),
            'menunggu' => Pemesanan::where('status', 'Menunggu Pembayaran')->count(),
        ];
        $orders = Pemesanan::with(['customer', 'armada', 'sopir', 'pembayaran'])
            ->latest()
            ->take(12)
            ->get();

        return view('admin.dashboard', compact('stats', 'orders'));
    }

    public function adminArmadas()
    {
        abort_unless(session('role') === 'admin', 403);

        $armadas = Armada::latest()->get();

        return view('admin.armada', compact('armadas'));
    }

    public function saveArmada(Request $r)
    {
        abort_unless(session('role') === 'admin', 403);

        $d = $r->validate([
            'nama_kendaraan' => 'required|string|max:120',
            'tipe' => 'required|string|max:50',
            'harga_sewa' => 'required|numeric|min:0',
            'transmisi' => 'nullable|string|max:40',
            'status_ketersediaan' => 'required|in:tersedia,disewa,perawatan',
            'plat_nomor' => 'nullable|string|max:20|unique:Rental_kendaraan_armada,plat_nomor',
        ]);

        Armada::create($d);

        return back()->with('success', 'Data armada berhasil ditambahkan.');
    }

    public function deleteArmada(Armada $armada)
    {
        abort_unless(session('role') === 'admin', 403);

        if ($armada->pemesanans()->exists()) {
            return back()->withErrors([
                'armada' => 'Armada memiliki riwayat pemesanan dan tidak dapat dihapus.',
            ]);
        }

        $armada->delete();

        return back()->with('success', 'Armada dihapus.');
    }

    public function updateOrder(Request $r, Pemesanan $p)
    {
        abort_unless(session('role') === 'admin', 403);

        $d = $r->validate([
            'status' => 'required|in:Menunggu Pembayaran,Menunggu Konfirmasi,Dikonfirmasi,Dalam Perjalanan,Selesai,Dibatalkan',
            'id_sopir' => 'nullable|exists:Rental_kendaraan_sopir,id_sopir',
            'status_pembayaran' => 'nullable|in:Menunggu,Dibayar,Ditolak',
        ]);

        $p->update([
            'status' => $d['status'],
            'id_sopir' => $d['id_sopir'] ?? $p->id_sopir,
        ]);

        if (isset($d['status_pembayaran'])) {
            $pay = $p->pembayaran()->first();

            if ($pay) {
                $pay->update([
                    'status_pembayaran' => $d['status_pembayaran'],
                    'tanggal_bayar' => $d['status_pembayaran'] === 'Dibayar'
                        ? now()
                        : $pay->tanggal_bayar,
                ]);
            }
        }

        return back()->with('success', 'Pesanan diperbarui.');
    }

    public function drivers()
    {
        abort_unless(session('role') === 'admin', 403);

        $sopirs = Sopir::latest()->get();

        return view('admin.sopir', compact('sopirs'));
    }

    public function saveDriver(Request $r)
    {
        abort_unless(session('role') === 'admin', 403);

        $d = $r->validate([
            'nama' => 'required|string|max:120',
            'no_hp' => 'required|string|max:25',
            'alamat' => 'nullable|string|max:500',
            'status' => 'required|in:tersedia,bertugas,nonaktif',
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('Rental_kendaraan_sopir', 'email'),
            ],
            'password' => 'required|string|min:8',
        ]);

        $d['password'] = Hash::make($d['password']);
        Sopir::create($d);

        return back()->with('success', 'Data sopir berhasil ditambahkan.');
    }

    public function deleteDriver(Sopir $sopir)
    {
        abort_unless(session('role') === 'admin', 403);

        if ($sopir->pemesanans()->whereIn('status', ['Dikonfirmasi', 'Dalam Perjalanan'])->exists()) {
            return back()->withErrors([
                'sopir' => 'Sopir sedang bertugas dan tidak dapat dihapus.',
            ]);
        }

        $sopir->delete();

        return back()->with('success', 'Data sopir dihapus.');
    }

    public function pay(Request $r, Pemesanan $p)
    {
        abort_unless(
            session('role') === 'customer' && $p->id_customer == session('user_id'),
            403
        );

        $d = $r->validate([
            'metode_pembayaran' => 'required|in:Transfer Bank,E-Wallet,QRIS',
        ]);

        $p->pembayaran()->update([
            'metode_pembayaran' => $d['metode_pembayaran'],
            'status_pembayaran' => 'Menunggu',
        ]);

        return back()->with(
            'success',
            'Metode pembayaran diperbarui. Sistem ini masih menggunakan simulasi pembayaran.'
        );
    }
}

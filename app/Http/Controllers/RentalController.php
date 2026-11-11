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
use Illuminate\Validation\ValidationException;

class RentalController extends Controller
{
    public function home()
    {
        $armadas = Armada::where('status_ketersediaan', 'tersedia')
            ->orderBy('id_armada', 'desc')
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

        $r->session()->regenerate();

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

        $a = Admin::where('email', $d['email'])->first();

        if ($a && Hash::check($d['password'], $a->password)) {
            $r->session()->regenerate();

            session([
                'user_id' => $a->id_admin,
                'user_name' => $a->nama,
                'role' => 'admin',
            ]);

            return redirect()->route('admin.dashboard');
        }

        $c = Customer::where('email', $d['email'])->first();

        if (!$c || !Hash::check($d['password'], $c->password)) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $r->session()->regenerate();

        session([
            'user_id' => $c->id_customer,
            'user_name' => $c->nama,
            'role' => 'customer',
        ]);

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

    /*
    |--------------------------------------------------------------------------
    | FORM PEMESANAN
    |--------------------------------------------------------------------------
    */

    public function createBookingForm(Armada $armada)
    {
        abort_unless(session('role') === 'customer', 403);

        $tanggalMinimal = now()->addDay()->toDateString();
        $tanggalMaksimal = now()->endOfMonth()->toDateString();

        $jumlahTerpakai = DB::table('Rental_kendaraan_tanggal_pemesanan as tp')
            ->join(
                'Rental_kendaraan_pemesanan as p',
                'p.id_pemesanan',
                '=',
                'tp.id_pemesanan'
            )
            ->where('p.id_armada', $armada->id_armada)
            ->where('p.status', '!=', 'Dibatalkan')
            ->whereBetween('tp.tanggal_sewa', [
                now()->startOfMonth()->toDateString(),
                $tanggalMaksimal,
            ])
            ->selectRaw('tp.tanggal_sewa, COUNT(*) as jumlah')
            ->groupBy('tp.tanggal_sewa')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->tanggal_sewa => (int) $item->jumlah,
                ];
            })
            ->all();

        return view('pemesanan.create', compact(
            'armada',
            'tanggalMinimal',
            'tanggalMaksimal',
            'jumlahTerpakai'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PEMESANAN
    |--------------------------------------------------------------------------
    */

    public function storeBooking(Request $r, Armada $armada)
    {
        abort_unless(session('role') === 'customer', 403);

        $tanggalMaksimal = now()->endOfMonth()->toDateString();

        $d = $r->validate([
            'tanggal_sewa' => [
                'required',
                'array',
                'min:1',
                'max:31',
            ],

            'tanggal_sewa.*' => [
                'required',
                'date_format:Y-m-d',
                'distinct',
                'after:today',
                'before_or_equal:' . $tanggalMaksimal,
            ],

            'durasi' => 'required|integer|min:1|max:31',

            'layanan' => 'required|in:ambil,diantar',

            'alamat_antar' => 'nullable|required_if:layanan,diantar|string|max:500',

            'metode_pembayaran' => 'required|in:Transfer Bank,E-Wallet,QRIS',
        ], [
            'tanggal_sewa.required' => 'Pilih tanggal sewa terlebih dahulu.',
            'tanggal_sewa.*.after' => 'Setiap tanggal sewa harus setelah hari ini.',
            'tanggal_sewa.*.before_or_equal' => 'Tanggal sewa harus berada pada bulan ini.',
            'tanggal_sewa.*.distinct' => 'Tanggal yang sama tidak boleh dipilih dua kali.',
        ]);

        $tanggalDipilih = collect($d['tanggal_sewa'])
            ->unique()
            ->sort()
            ->values();

        if ($tanggalDipilih->count() !== (int) $d['durasi']) {
            return back()
                ->withErrors([
                    'tanggal_sewa' => 'Jumlah tanggal yang dipilih harus sama dengan durasi sewa.',
                ])
                ->withInput();
        }

        $p = DB::transaction(function () use ($d, $armada, $tanggalDipilih) {
            // Kunci data armada agar pemeriksaan stok tidak berbenturan
            // dengan transaksi pemesanan lain.
            $armadaTerkunci = Armada::where(
                'id_armada',
                $armada->id_armada
            )
                ->lockForUpdate()
                ->firstOrFail();

            if (
                $armadaTerkunci->status_ketersediaan !== 'tersedia' ||
                (int) $armadaTerkunci->stok < 1
            ) {
                throw ValidationException::withMessages([
                    'armada' => 'Armada sedang tidak tersedia untuk dipesan.',
                ]);
            }

            // Hitung jumlah kendaraan yang sudah dipesan pada setiap tanggal.
            $terpakai = DB::table('Rental_kendaraan_tanggal_pemesanan as tp')
                ->join(
                    'Rental_kendaraan_pemesanan as p',
                    'p.id_pemesanan',
                    '=',
                    'tp.id_pemesanan'
                )
                ->where('p.id_armada', $armadaTerkunci->id_armada)
                ->where('p.status', '!=', 'Dibatalkan')
                ->whereIn('tp.tanggal_sewa', $tanggalDipilih->all())
                ->selectRaw('tp.tanggal_sewa, COUNT(*) as jumlah')
                ->groupBy('tp.tanggal_sewa')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [
                        $item->tanggal_sewa => (int) $item->jumlah,
                    ];
                });

            // Pastikan stok tersedia pada semua tanggal yang dipilih.
            foreach ($tanggalDipilih as $tanggal) {
                $jumlah = (int) $terpakai->get($tanggal, 0);

                if ($jumlah >= (int) $armadaTerkunci->stok) {
                    throw ValidationException::withMessages([
                        'tanggal_sewa' =>
                            'Stok kendaraan sudah habis pada tanggal ' .
                            \Carbon\Carbon::parse($tanggal)->format('d-m-Y') .
                            '. Silakan pilih tanggal lain.',
                    ]);
                }
            }

            // Buat data pemesanan utama.
            $pesanan = Pemesanan::create([
                'id_customer' => session('user_id'),
                'id_armada' => $armadaTerkunci->id_armada,
                'tanggal_sewa' => $tanggalDipilih->first(),
                'durasi' => $tanggalDipilih->count(),
                'total_biaya' =>
                    $armadaTerkunci->harga_sewa * $tanggalDipilih->count(),
                'layanan' => $d['layanan'],
                'alamat_antar' => $d['alamat_antar'] ?? null,
                'status' => 'Menunggu Pembayaran',
            ]);

            // Simpan setiap tanggal sewa sebagai baris terpisah.
            foreach ($tanggalDipilih as $tanggal) {
                $pesanan->tanggalPemesanan()->create([
                    'tanggal_sewa' => $tanggal,
                ]);
            }

            // Buat data pembayaran.
            Pembayaran::create([
                'id_pemesanan' => $pesanan->id_pemesanan,
                'metode_pembayaran' => $d['metode_pembayaran'],
                'status_pembayaran' => 'Menunggu',
            ]);

            return $pesanan;
        });

        return redirect()
            ->route('customer.orders')
            ->with(
                'success',
                'Pemesanan tersimpan. Silakan tunggu verifikasi pembayaran. Nomor pesanan #' .
                $p->id_pemesanan
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PROFIL CUSTOMER
    |--------------------------------------------------------------------------
    */

    public function customerProfile()
    {
        abort_unless(session('role') === 'customer', 403);

        $customer = Customer::findOrFail(session('user_id'));

        return view('customer.profil', compact('customer'));
    }

    public function updateCustomerProfile(Request $r)
    {
        abort_unless(session('role') === 'customer', 403);

        $customer = Customer::findOrFail(session('user_id'));

        $data = $r->validate([
            'nama' => ['required', 'string', 'max:120'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('Rental_kendaraan_customer', 'email')
                    ->ignore($customer->id_customer, 'id_customer'),
            ],
            'no_hp' => ['required', 'string', 'max:25'],
        ]);

        $customer->update($data);

        session([
            'user_name' => $customer->nama,
        ]);

        return redirect()
            ->route('customer.profile')
            ->with('success', 'Informasi profil berhasil diperbarui.');
    }

    public function updateCustomerPassword(Request $r)
    {
        abort_unless(session('role') === 'customer', 403);

        $customer = Customer::findOrFail(session('user_id'));

        $data = $r->validate([
            'password_lama' => ['required', 'string'],
            'password_baru' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password_baru.min' => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak sama.',
        ]);

        if (!Hash::check($data['password_lama'], $customer->password)) {
            return back()
                ->withErrors([
                    'password_lama' => 'Password lama yang kamu masukkan tidak sesuai.',
                ], 'password')
                ->withInput();
        }

        $customer->update([
            'password' => Hash::make($data['password_baru']),
        ]);

        return redirect()
            ->route('customer.profile')
            ->with('success_password', 'Password berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN ADMIN
    |--------------------------------------------------------------------------
    */

    public function adminLoginForm()
    {
        return view('admin.login');
    }

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

        $request->session()->regenerate();

        $request->session()->put([
            'user_id' => $admin->id_admin,
            'user_name' => $admin->nama,
            'role' => 'admin',
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function adminLogout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /*
    |--------------------------------------------------------------------------
    | PEMBATALAN PESANAN CUSTOMER
    |--------------------------------------------------------------------------
    */

    public function cancelBooking(Pemesanan $p)
    {
        abort_unless(
            session('role') === 'customer' &&
            $p->id_customer == session('user_id'),
            403
        );

        if (!in_array($p->status, [
            'Menunggu Pembayaran',
            'Menunggu Konfirmasi',
        ])) {
            return back()->withErrors([
                'status' => 'Pesanan yang sudah diproses tidak dapat dibatalkan.',
            ]);
        }

        DB::transaction(function () use ($p) {
            Armada::where('id_armada', $p->id_armada)
                ->lockForUpdate()
                ->first();

            $pesananTerkunci = Pemesanan::where(
                'id_pemesanan',
                $p->id_pemesanan
            )
                ->lockForUpdate()
                ->firstOrFail();

            if (in_array($pesananTerkunci->status, [
                'Menunggu Pembayaran',
                'Menunggu Konfirmasi',
            ])) {
                $pesananTerkunci->update([
                    'status' => 'Dibatalkan',
                ]);
            }
        });

        return back()->with(
            'success',
            'Pesanan berhasil dibatalkan. Stok pada semua tanggal pilihan telah tersedia kembali.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        abort_unless(session('role') === 'admin', 403);

        $stats = [
            'armada' => Armada::count(),
            'customer' => Customer::count(),
            'pesanan' => Pemesanan::count(),
            'menunggu' => Pemesanan::where(
                'status',
                'Menunggu Pembayaran'
            )->count(),
        ];

        $orders = Pemesanan::with([
            'customer',
            'armada',
            'sopir',
            'pembayaran',
        ])
            ->orderBy('id_pemesanan', 'desc')
            ->take(12)
            ->get();

        return view('admin.dashboard', compact('stats', 'orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA ARMADA
    |--------------------------------------------------------------------------
    */

    public function adminArmadas()
    {
        abort_unless(session('role') === 'admin', 403);

        $armadas = Armada::orderBy('id_armada', 'desc')->get();

        return view('admin.armada', compact('armadas'));
    }

    public function saveArmada(Request $r)
    {
        abort_unless(session('role') === 'admin', 403);

        $d = $r->validate([
            'nama_kendaraan' => 'required|string|max:120',
            'tipe' => 'required|string|max:50',
            'harga_sewa' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:1|max:1000',
            'transmisi' => 'nullable|string|max:40',
            'status_ketersediaan' => 'required|in:tersedia,disewa,perawatan',
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

    public function updateArmadaStock(Request $r, Armada $armada)
    {
        abort_unless(session('role') === 'admin', 403);

        $data = $r->validate([
            'stok' => ['required', 'integer', 'min:0', 'max:1000'],
        ]);

        DB::transaction(function () use ($armada, $data) {
            $armadaTerkunci = Armada::where(
                'id_armada',
                $armada->id_armada
            )
                ->lockForUpdate()
                ->firstOrFail();

            $konflik = DB::table('Rental_kendaraan_tanggal_pemesanan as tp')
                ->join(
                    'Rental_kendaraan_pemesanan as p',
                    'p.id_pemesanan',
                    '=',
                    'tp.id_pemesanan'
                )
                ->where('p.id_armada', $armadaTerkunci->id_armada)
                ->where('p.status', '!=', 'Dibatalkan')
                ->whereDate('tp.tanggal_sewa', '>=', now()->toDateString())
                ->selectRaw('tp.tanggal_sewa, COUNT(*) as jumlah')
                ->groupBy('tp.tanggal_sewa')
                ->havingRaw('COUNT(*) > ?', [(int) $data['stok']])
                ->orderBy('tp.tanggal_sewa')
                ->first();

            if ($konflik) {
                throw ValidationException::withMessages([
                    'stok' =>
                        'Stok tidak dapat dikurangi menjadi ' . $data['stok'] .
                        ' karena tanggal ' .
                        \Carbon\Carbon::parse($konflik->tanggal_sewa)->format('d-m-Y') .
                        ' sudah memiliki ' . $konflik->jumlah .
                        ' pesanan aktif.',
                ]);
            }

            $armadaTerkunci->update([
                'stok' => (int) $data['stok'],
            ]);
        });

        return back()->with(
            'success',
            'Stok armada berhasil diperbarui.'
        );
    }

public function updateArmadaStatus(Request $r, Armada $armada)
{
    abort_unless(session('role') === 'admin', 403);

    $data = $r->validate([
        'status_ketersediaan' => [
            'required',
            'in:tersedia,disewa,perawatan',
        ],
    ]);

    $armada->update([
        'status_ketersediaan' => $data['status_ketersediaan'],
    ]);

    return back()->with(
        'success',
        'Status kendaraan berhasil diperbarui.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | UPDATE PESANAN OLEH ADMIN
    |--------------------------------------------------------------------------
    */

    public function updateOrder(Request $r, Pemesanan $p)
    {
        abort_unless(session('role') === 'admin', 403);

        $d = $r->validate([
            'status' => [
                'required',
                'in:Menunggu Pembayaran,Menunggu Konfirmasi,Dikonfirmasi,Dalam Perjalanan,Selesai,Dibatalkan',
            ],

            'id_sopir' => [
                'nullable',
                'exists:Rental_kendaraan_sopir,id_sopir',
            ],

            'status_pembayaran' => [
                'nullable',
                'in:Menunggu,Dibayar,Ditolak',
            ],
        ]);

        DB::transaction(function () use ($d, $p) {
            // Kunci data armada.
            $armada = Armada::where(
                'id_armada',
                $p->id_armada
            )
                ->lockForUpdate()
                ->firstOrFail();

            // Ambil ulang data pesanan dengan row lock.
            $pesanan = Pemesanan::where(
                'id_pemesanan',
                $p->id_pemesanan
            )
                ->lockForUpdate()
                ->firstOrFail();

            // Jika pesanan dibatalkan lalu diaktifkan kembali,
            // periksa ketersediaan stok pada setiap tanggal.
            if (
                $pesanan->status === 'Dibatalkan' &&
                $d['status'] !== 'Dibatalkan'
            ) {
                $tanggalPesanan = DB::table(
                    'Rental_kendaraan_tanggal_pemesanan'
                )
                    ->where('id_pemesanan', $pesanan->id_pemesanan)
                    ->whereDate(
                        'tanggal_sewa',
                        '>=',
                        now()->toDateString()
                    )
                    ->pluck('tanggal_sewa');

                $terpakai = DB::table(
                    'Rental_kendaraan_tanggal_pemesanan as tp'
                )
                    ->join(
                        'Rental_kendaraan_pemesanan as p',
                        'p.id_pemesanan',
                        '=',
                        'tp.id_pemesanan'
                    )
                    ->where('p.id_armada', $armada->id_armada)
                    ->where('p.status', '!=', 'Dibatalkan')
                    ->whereIn('tp.tanggal_sewa', $tanggalPesanan)
                    ->selectRaw('tp.tanggal_sewa, COUNT(*) as jumlah')
                    ->groupBy('tp.tanggal_sewa')
                    ->get()
                    ->keyBy('tanggal_sewa');

                foreach ($tanggalPesanan as $tanggal) {
                    $barisTerpakai = $terpakai->get($tanggal);
                    $jumlahTerpakai = (int) ($barisTerpakai->jumlah ?? 0);

                    if ($jumlahTerpakai >= (int) $armada->stok) {
                        throw ValidationException::withMessages([
                            'status' =>
                                'Pesanan tidak dapat diaktifkan kembali karena stok kendaraan sudah penuh pada tanggal ' .
                                \Carbon\Carbon::parse($tanggal)->format('d-m-Y') .
                                '. Silakan periksa ketersediaan armada.',
                        ]);
                    }
                }
            }

            // Perbarui status pesanan dan sopir.
            $pesanan->update([
                'status' => $d['status'],
                'id_sopir' => $d['id_sopir'] ?? $pesanan->id_sopir,
            ]);

            // Perbarui status pembayaran jika dikirim dari form admin.
            if (isset($d['status_pembayaran'])) {
                $pembayaran = $pesanan->pembayaran()->first();

                if ($pembayaran) {
                    $pembayaran->update([
                        'status_pembayaran' => $d['status_pembayaran'],
                        'tanggal_bayar' =>
                            $d['status_pembayaran'] === 'Dibayar'
                                ? now()
                                : $pembayaran->tanggal_bayar,
                    ]);
                }
            }
        });

        return back()->with(
            'success',
            'Pesanan berhasil diperbarui.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | KELOLA SOPIR
    |--------------------------------------------------------------------------
    */

    public function drivers()
    {
        abort_unless(session('role') === 'admin', 403);

        $sopirs = Sopir::orderBy('id_sopir', 'desc')->get();

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

        if (
            $sopir->pemesanans()
                ->whereIn('status', ['Dikonfirmasi', 'Dalam Perjalanan'])
                ->exists()
        ) {
            return back()->withErrors([
                'sopir' => 'Sopir sedang bertugas dan tidak dapat dihapus.',
            ]);
        }

        $sopir->delete();

        return back()->with('success', 'Data sopir dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | PESANAN CUSTOMER
    |--------------------------------------------------------------------------
    | PENTING: customerOrders hanya boleh ada SATU KALI di controller ini.
    */

    public function customerOrders()
    {
        abort_unless(session('role') === 'customer', 403);

        $orders = Pemesanan::with([
            'armada',
            'sopir',
            'pembayaran',
            'tanggalPemesanan',
        ])
            ->where('id_customer', session('user_id'))
            ->orderBy('id_pemesanan', 'desc')
            ->get();

        return view('pemesanan.index', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN CUSTOMER
    |--------------------------------------------------------------------------
    */

    public function pay(Request $r, Pemesanan $p)
    {
        abort_unless(
            session('role') === 'customer' &&
            $p->id_customer == session('user_id'),
            403
        );

        $d = $r->validate([
            'metode_pembayaran' => 'required|in:Transfer Bank,E-Wallet,QRIS',
        ]);

        if ($p->status !== 'Menunggu Pembayaran') {
            return back()->withErrors([
                'pembayaran' => 'Metode pembayaran hanya dapat diubah saat pesanan menunggu pembayaran.',
            ]);
        }

        $pembayaran = $p->pembayaran;

        if (!$pembayaran) {
            return back()->withErrors([
                'pembayaran' => 'Data pembayaran untuk pesanan ini tidak ditemukan. Hubungi admin.',
            ]);
        }

        $pembayaran->update([
            'metode_pembayaran' => $d['metode_pembayaran'],
            'status_pembayaran' => 'Menunggu',
        ]);

        return back()->with(
            'success',
            'Metode pembayaran diperbarui. Sistem ini masih menggunakan simulasi pembayaran.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN PENYEWAAN
    |--------------------------------------------------------------------------
    */

    public function rentalReports(Request $request)
    {
        abort_unless(session('role') === 'admin', 403);

        $filters = $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|in:Menunggu Pembayaran,Menunggu Konfirmasi,Dikonfirmasi,Dalam Perjalanan,Selesai,Dibatalkan',
        ]);

        $query = Pemesanan::with([
            'customer',
            'armada',
            'sopir',
            'pembayaran',
            'tanggalPemesanan',
        ]);

        // Filter tanggal menggunakan semua tanggal pilihan customer.
        // Pesanan lama tanpa detail tanggal menggunakan tanggal_sewa utama.
        if (
            !empty($filters['tanggal_mulai']) ||
            !empty($filters['tanggal_selesai'])
        ) {
            $tanggalMulai = $filters['tanggal_mulai'] ?? null;
            $tanggalSelesai = $filters['tanggal_selesai'] ?? null;

            $query->where(function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereHas(
                    'tanggalPemesanan',
                    function ($tanggalQuery) use ($tanggalMulai, $tanggalSelesai) {
                        if ($tanggalMulai) {
                            $tanggalQuery->whereDate(
                                'tanggal_sewa',
                                '>=',
                                $tanggalMulai
                            );
                        }

                        if ($tanggalSelesai) {
                            $tanggalQuery->whereDate(
                                'tanggal_sewa',
                                '<=',
                                $tanggalSelesai
                            );
                        }
                    }
                );

                $q->orWhere(function ($legacyQuery) use (
                    $tanggalMulai,
                    $tanggalSelesai
                ) {
                    $legacyQuery->whereDoesntHave('tanggalPemesanan');

                    if ($tanggalMulai) {
                        $legacyQuery->whereDate(
                            'tanggal_sewa',
                            '>=',
                            $tanggalMulai
                        );
                    }

                    if ($tanggalSelesai) {
                        $legacyQuery->whereDate(
                            'tanggal_sewa',
                            '<=',
                            $tanggalSelesai
                        );
                    }
                });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $orders = $query
            ->orderBy('id_pemesanan', 'desc')
            ->get();

        $totalPemesanan = $orders->count();

        $totalPendapatan = $orders
            ->filter(function ($order) {
                return $order->pembayaran &&
                    $order->pembayaran->status_pembayaran === 'Dibayar';
            })
            ->sum('total_biaya');

        $pemesananAktif = $orders
            ->whereIn('status', ['Dikonfirmasi', 'Dalam Perjalanan'])
            ->count();

        $pemesananMenunggu = $orders
            ->whereIn('status', [
                'Menunggu Pembayaran',
                'Menunggu Konfirmasi',
            ])
            ->count();

        return view('admin.laporan', compact(
            'orders',
            'filters',
            'totalPemesanan',
            'totalPendapatan',
            'pemesananAktif',
            'pemesananMenunggu'
        ));
    }
}
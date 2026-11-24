# Sistem Penyewaan Kendaraan — Laravel 12 + MySQL

## Catatan
Paket ini melengkapi fondasi ZIP awal dengan implementasi dasar yang mengacu pada diagram ER dan laporan RPL: Customer, Verifikasi, Armada, Sopir, Pemesanan, Pembayaran, serta alur admin/customer. Pembayaran masih simulasi; email/SMS verifikasi, upload KTP, QRIS sungguhan, pencarian ketersediaan berdasarkan benturan tanggal, edit armada, dan hak akses melalui middleware khusus masih perlu pengembangan lanjutan sebelum dipakai secara nyata.

## Menjalankan di Windows/XAMPP
1. Ekstrak folder proyek ke `D:\xampp\htdocs\PenyewaanKendaraan` (sesuaikan lokasi XAMPP).
2. Jalankan Apache dan MySQL dari XAMPP.
3. Buka `http://localhost/phpmyadmin`, buat database bernama `penyewaan_kendaraan` dengan collation `utf8mb4_unicode_ci`.
4. Salin `.env.example` menjadi `.env` lalu pastikan pengaturan berikut:
   ```env
   APP_NAME="Sistem Penyewaan Kendaraan"
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://127.0.0.1:8000
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=penyewaan_kendaraan
   DB_USERNAME=root
   DB_PASSWORD=
   SESSION_DRIVER=file
   CACHE_STORE=file
   QUEUE_CONNECTION=sync
   ```
5. Buka terminal di folder proyek, jalankan:
   ```bash
   composer install
   php artisan key:generate
   php artisan optimize:clear
   php artisan migrate --seed
   php artisan serve
   ```
6. Buka `http://127.0.0.1:8000`.

## Akun admin demo
- Email: `admin@rental.test`
- Password: `Admin123!`

Akun demo di atas dibuat untuk pengujian lokal saja. Sebelum deployment, pindahkan kredensial admin ke konfigurasi/penyimpanan akun admin yang aman dan jangan gunakan password contoh.

## Alur utama yang tersedia
- Customer daftar dan login.
- Customer melihat armada yang tersedia, membuat pesanan dengan tanggal, durasi, layanan ambil/diantar, dan metode pembayaran simulasi.
- Total biaya dihitung dari harga harian dikali durasi.
- Customer melihat riwayat dan membatalkan pesanan yang belum diproses.
- Admin melihat dashboard dan pesanan, memperbarui status pesanan/pembayaran, memilih sopir, mengelola data armada dan sopir.

## Peringatan pengembangan
- Status verifikasi akun disimpan, tetapi verifikasi email/SMS belum diintegrasikan.
- Status pembayaran admin dapat diubah untuk kebutuhan demo; tidak ada bukti transfer atau gateway pembayaran.
- Ketersediaan armada masih berdasarkan status umum `status_ketersediaan`, belum mengunci benturan tanggal sewa secara transaksional.
- Fitur CRUD armada/sopir pada paket awal ini mencakup tambah dan hapus; edit data perlu ditambahkan bila diwajibkan dalam penilaian.
- Role admin demo menggunakan kredensial tetap untuk kemudahan demonstrasi lokal; jangan dipublikasikan ke internet.
- Jalankan `php artisan test` dan lakukan pengujian manual setelah migrasi di lingkungan PHP/MySQL yang sesuai.

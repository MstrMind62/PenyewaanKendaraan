<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Rental_kendaraan_tanggal_pemesanan', function (Blueprint $table) {
            $table->id('id_detail_tanggal');

            $table->foreignId('id_pemesanan')
                ->constrained('Rental_kendaraan_pemesanan', 'id_pemesanan')
                ->cascadeOnDelete();

            $table->date('tanggal_sewa');
            $table->timestamps();

            $table->unique(
                ['id_pemesanan', 'tanggal_sewa'],
                'uniq_pemesanan_tanggal'
            );

            $table->index('tanggal_sewa', 'idx_tanggal_pemesanan');
        });

        // Memindahkan data pesanan lama ke tabel tanggal baru.
        // Durasi pesanan lama dianggap sebagai hari berurutan.
        $pesanans = DB::table('Rental_kendaraan_pemesanan')->get();

        foreach ($pesanans as $pesanan) {
            $tanggalAwal = Carbon::parse($pesanan->tanggal_sewa);
            $durasi = max(1, (int) $pesanan->durasi);

            for ($i = 0; $i < $durasi; $i++) {
                $tanggal = $tanggalAwal
                    ->copy()
                    ->addDays($i)
                    ->toDateString();

                DB::table('Rental_kendaraan_tanggal_pemesanan')
                    ->insertOrIgnore([
                        'id_pemesanan' => $pesanan->id_pemesanan,
                        'tanggal_sewa' => $tanggal,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('Rental_kendaraan_tanggal_pemesanan');
    }
};
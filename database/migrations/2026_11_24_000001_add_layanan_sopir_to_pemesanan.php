<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('Rental_kendaraan_pemesanan', function (Blueprint $table) {
            $table->boolean('menggunakan_sopir')->default(false)->after('durasi');
        });
    }

    public function down(): void
    {
        Schema::table('Rental_kendaraan_pemesanan', function (Blueprint $table) {
            $table->dropColumn('menggunakan_sopir');
        });
    }
};

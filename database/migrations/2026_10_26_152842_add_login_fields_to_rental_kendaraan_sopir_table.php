
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('Rental_kendaraan_sopir', 'email')) {
            Schema::table('Rental_kendaraan_sopir', function (Blueprint $table) {
                $table->string('email')->nullable()->unique();
            });
        }

        if (!Schema::hasColumn('Rental_kendaraan_sopir', 'password')) {
            Schema::table('Rental_kendaraan_sopir', function (Blueprint $table) {
                $table->string('password')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Tidak menghapus kolom agar data lama tetap aman.
    }
};

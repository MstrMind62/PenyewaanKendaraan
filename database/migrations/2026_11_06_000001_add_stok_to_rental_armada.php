
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('Rental_kendaraan_armada', 'stok')) {
            Schema::table('Rental_kendaraan_armada', function (Blueprint $table) {
                $table->unsignedInteger('stok')->default(1);
            });
        }
    }

    public function down(): void
    {
        // Tidak menghapus stok yang mungkin sudah berisi data.
    }
};

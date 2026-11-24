<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('Rental_kendaraan_sopir', function(Blueprint $t){ $t->id('id_sopir'); $t->string('nama',120); $t->string('no_hp',25); $t->text('alamat')->nullable(); $t->string('status',30)->default('tersedia'); $t->timestamps(); }); } public function down(): void { Schema::dropIfExists('Rental_kendaraan_sopir'); }};

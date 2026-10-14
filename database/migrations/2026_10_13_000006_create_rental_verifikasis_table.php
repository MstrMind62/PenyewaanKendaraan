<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('Rental_kendaraan_verifikasi', function(Blueprint $t){ $t->id('id_verifikasi'); $t->foreignId('id_customer')->constrained('Rental_kendaraan_customer','id_customer')->cascadeOnDelete(); $t->string('kode_verifikasi',10); $t->string('status',30)->default('belum'); $t->timestamps(); }); } public function down(): void { Schema::dropIfExists('Rental_kendaraan_verifikasi'); }};

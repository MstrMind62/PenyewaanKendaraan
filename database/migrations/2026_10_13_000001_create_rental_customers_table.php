<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('Rental_kendaraan_customer', function(Blueprint $t){ $t->id('id_customer'); $t->string('nama',120); $t->string('email',150)->unique(); $t->string('no_hp',25); $t->string('password'); $t->string('ktp_path')->nullable(); $t->string('status_verifikasi',30)->default('belum'); $t->timestamps(); }); } public function down(): void { Schema::dropIfExists('Rental_kendaraan_customer'); }};

<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('Rental_kendaraan_admin', function(Blueprint $t){ $t->id('id_admin'); $t->string('nama',120); $t->string('email',150)->unique(); $t->string('password'); $t->timestamps(); }); } public function down(): void { Schema::dropIfExists('Rental_kendaraan_admin'); }};

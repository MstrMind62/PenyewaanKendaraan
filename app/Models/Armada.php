<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Armada extends Model
{
    use HasFactory;

    protected $table = 'Rental_kendaraan_armada'; // Sesuaikan dengan nama tabel di database Anda
    protected $primaryKey = 'id_armada';          // Primary key yang digunakan

    public function getRouteKeyName()
    {
        return 'id_armada';
    }
}
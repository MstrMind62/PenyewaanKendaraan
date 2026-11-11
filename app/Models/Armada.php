<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armada extends Model
{
    protected $table = 'Rental_kendaraan_armada';

    protected $primaryKey = 'id_armada';

    public $timestamps = false;

    protected $fillable = [
        'nama_kendaraan',
        'tipe',
        'harga_sewa',
        'stok',
        'transmisi',
        'status_ketersediaan',
        'plat_nomor',
        'gambar',
    ];

    public function getRouteKeyName()
    {
        return $this->primaryKey;
    }

    public function pemesanans()
    {
        return $this->hasMany(
            Pemesanan::class,
            'id_armada',
            'id_armada'
        );
    }
}
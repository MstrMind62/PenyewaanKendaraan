<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanggalPemesanan extends Model
{
    protected $table = 'Rental_kendaraan_tanggal_pemesanan';

    protected $primaryKey = 'id_detail_tanggal';

    protected $fillable = [
        'id_pemesanan',
        'tanggal_sewa',
    ];

    protected $casts = [
        'tanggal_sewa' => 'date',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(
            Pemesanan::class,
            'id_pemesanan',
            'id_pemesanan'
        );
    }
}
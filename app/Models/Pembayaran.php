<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model

{
    protected $table = 'Rental_kendaraan_pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_pemesanan',
        'tanggal_bayar',
        'metode_pembayaran',
        'status_pembayaran',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return $this->primaryKey;
    }

    public function pemesanan()
    {
        return $this->belongsTo(
            Pemesanan::class,
            'id_pemesanan',
            'id_pemesanan'
        );
    }
}
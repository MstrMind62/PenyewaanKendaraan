<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sopir extends Model
{
    protected $table = 'Rental_kendaraan_sopir';

    protected $primaryKey = 'id_sopir';

    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'status',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    public function getRouteKeyName(): string
    {
        return $this->primaryKey;
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'id_sopir', 'id_sopir');
    }
}
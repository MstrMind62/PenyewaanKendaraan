<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'Rental_kendaraan_customer';

    protected $primaryKey = 'id_customer';

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'password',
        'status_verifikasi',
    ];
}

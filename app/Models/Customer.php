<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    
    protected $table = 'customer';
    
    
    public $timestamps = false;
    
    
    protected $primaryKey = 'id_customer';
    
    protected $fillable = [
        'nama', 'email', 'no_hp', 'password', 'status_verifikasi' // Sesuaikan dengan milik Anda
    ];
}
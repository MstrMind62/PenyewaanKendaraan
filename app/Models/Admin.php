<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Admin extends Model { protected $table='Rental_kendaraan_admin'; protected $primaryKey='id_admin'; protected $fillable=['nama','email','password']; protected $hidden=['password']; public function getRouteKeyName(){return $this->primaryKey;} }

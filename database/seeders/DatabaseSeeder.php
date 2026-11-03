<?php
<<<<<<< HEAD

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
=======
namespace Database\Seeders;
use Illuminate\Database\Seeder; use Illuminate\Support\Facades\Hash; use App\Models\{Admin,Armada,Sopir};
class DatabaseSeeder extends Seeder { public function run(): void { if(!Admin::where('email','admin@rental.test')->exists()){Admin::create(['nama'=>'Administrator','email'=>'admin@rental.test','password'=>Hash::make('Admin123!')]);} if(Armada::count()===0){Armada::create(['nama_kendaraan'=>'Contoh Toyota Avanza','tipe'=>'Mobil','harga_sewa'=>350000,'transmisi'=>'Automatic','status_ketersediaan'=>'tersedia','plat_nomor'=>'AB 1234 XX']);Armada::create(['nama_kendaraan'=>'Contoh HiAce','tipe'=>'HiAce','harga_sewa'=>900000,'transmisi'=>'Manual','status_ketersediaan'=>'tersedia','plat_nomor'=>'AB 5678 XX']);} if(Sopir::count()===0){Sopir::create(['nama'=>'Sopir Contoh','no_hp'=>'081234567890','alamat'=>'Yogyakarta','status'=>'tersedia']);} } }
>>>>>>> 02e1f13f5272f8f264ae52707d599f57b8d485a5

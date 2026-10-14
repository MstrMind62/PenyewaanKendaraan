<?php
use Illuminate\Support\Facades\Route; use App\Http\Controllers\RentalController;
Route::get('/',[RentalController::class,'home'])->name('home');
Route::get('/daftar',[RentalController::class,'registerForm'])->name('register'); Route::post('/daftar',[RentalController::class,'register'])->name('register.store');
Route::get('/login',[RentalController::class,'loginForm'])->name('login'); Route::post('/login',[RentalController::class,'login'])->name('login.store'); Route::post('/logout',[RentalController::class,'logout'])->name('logout');
Route::get('/armada',[RentalController::class,'armadas'])->name('armada.index');
Route::get('/armada/{armada}/pesan',[RentalController::class,'createBookingForm'])->name('booking.create'); Route::post('/armada/{armada}/pesan',[RentalController::class,'storeBooking'])->name('booking.store');
Route::get('/pesanan-saya',[RentalController::class,'customerOrders'])->name('customer.orders'); Route::post('/pesanan/{p}/batal',[RentalController::class,'cancelBooking'])->name('booking.cancel'); Route::post('/pesanan/{p}/pembayaran',[RentalController::class,'pay'])->name('booking.pay');
Route::get('/admin',[RentalController::class,'dashboard'])->name('admin.dashboard'); Route::get('/admin/armada',[RentalController::class,'adminArmadas'])->name('admin.armada'); Route::post('/admin/armada',[RentalController::class,'saveArmada'])->name('admin.armada.store'); Route::delete('/admin/armada/{armada}',[RentalController::class,'deleteArmada'])->name('admin.armada.delete');
Route::patch('/admin/pesanan/{p}',[RentalController::class,'updateOrder'])->name('admin.orders.update'); Route::get('/admin/sopir',[RentalController::class,'drivers'])->name('admin.sopir'); Route::post('/admin/sopir',[RentalController::class,'saveDriver'])->name('admin.sopir.store'); Route::delete('/admin/sopir/{sopir}',[RentalController::class,'deleteDriver'])->name('admin.sopir.delete');

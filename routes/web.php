<?php

use App\Http\Controllers\RentalController;
use App\Http\Controllers\SupirController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RentalController::class, 'home'])->name('home');

Route::get('/daftar', [RentalController::class, 'registerForm'])->name('register');
Route::post('/daftar', [RentalController::class, 'register'])->name('register.store');
Route::get('/login', [RentalController::class, 'loginForm'])->name('login');
Route::post('/login', [RentalController::class, 'login'])->name('login.store');
Route::post('/logout', [RentalController::class, 'logout'])->name('logout');

// Login dan logout Admin
Route::get('/admin/login', [RentalController::class, 'adminLoginForm'])
    ->name('admin.login');

Route::post('/admin/login', [RentalController::class, 'adminLogin'])
    ->name('admin.login.store');

Route::post('/admin/logout', [RentalController::class, 'adminLogout'])
    ->name('admin.logout');

Route::get('/armada', [RentalController::class, 'armadas'])->name('armada.index');
Route::get('/armada/{armada}/pesan', [RentalController::class, 'createBookingForm'])->name('booking.create');
Route::post('/armada/{armada}/pesan', [RentalController::class, 'storeBooking'])->name('booking.store');
Route::get('/pesanan-saya', [RentalController::class, 'customerOrders'])->name('customer.orders');
Route::post('/pesanan/{p}/batal', [RentalController::class, 'cancelBooking'])->name('booking.cancel');
Route::post('/pesanan/{p}/pembayaran', [RentalController::class, 'pay'])->name('booking.pay');

Route::get('/admin', [RentalController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/armada', [RentalController::class, 'adminArmadas'])->name('admin.armada');
Route::post('/admin/armada', [RentalController::class, 'saveArmada'])->name('admin.armada.store');
Route::delete('/admin/armada/{armada}', [RentalController::class, 'deleteArmada'])->name('admin.armada.delete');
Route::patch('/admin/pesanan/{p}', [RentalController::class, 'updateOrder'])->name('admin.orders.update');
Route::get('/admin/sopir', [RentalController::class, 'drivers'])->name('admin.sopir');
Route::post('/admin/sopir', [RentalController::class, 'saveDriver'])->name('admin.sopir.store');
Route::delete('/admin/sopir/{sopir}', [RentalController::class, 'deleteDriver'])->name('admin.sopir.delete');

Route::prefix('supir')->name('supir.')->group(function () {
    Route::get('/login', [SupirController::class, 'loginForm'])->name('login');
    Route::post('/login', [SupirController::class, 'login'])->name('login.store');
    Route::post('/logout', [SupirController::class, 'logout'])->name('logout');
    Route::get('/', [SupirController::class, 'dashboard'])->name('dashboard');
    Route::get('/tugas', [SupirController::class, 'tasks'])->name('tugas');
    Route::get('/tugas/{p}', [SupirController::class, 'showTask'])->name('tugas.detail');
    Route::patch('/tugas/{p}/status', [SupirController::class, 'updateTaskStatus'])->name('tugas.status');
});

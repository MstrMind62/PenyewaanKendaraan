<?php

use App\Http\Controllers\ArmadaController;

Route::get('/armada', [ArmadaController::class, 'index']);
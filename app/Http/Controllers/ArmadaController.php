<?php

namespace App\Http\Controllers;

use App\Models\Armada;

class ArmadaController extends Controller
{
    public function index()
    {
        $armadas = Armada::all();
        return view('armada.index', compact('armadas'));    
        }
}
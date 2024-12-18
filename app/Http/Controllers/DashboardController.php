<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MejaBiliard;
use App\Models\Meja;
use App\Models\OrderBiliard;
use App\Models\Pesanan;

class DashboardController extends Controller
{
    public function index()
    {
        $mejabiliard = mejabiliard::with('order')
        ->orderBy('id_meja_biliard')->get();
        $meja = meja::with('pesanan')
        ->orderBy('id_meja')->get();
        return view('dashboard.index', compact('mejabiliard','meja'));

    }
    public function store()
    {
        
    }
}

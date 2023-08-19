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

        if(auth()->user()->level == 5 || auth()->user()->level == 1 || auth()->user()->level == 6) {
            return redirect()->to('meja');
        }

        if(auth()->user()->level == 4) {
            return redirect()->to('menu');
        }

        // dd($meja);
        return view('dashboard.index', compact('mejabiliard','meja'));

    }
    public function store()
    {

    }
}

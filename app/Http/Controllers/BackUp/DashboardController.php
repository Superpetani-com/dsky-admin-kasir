<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MejaBiliard;
use App\Models\Meja;

class DashboardController extends Controller
{
    public function index()
    {
        $mejabiliard = mejabiliard::orderBy('id_meja_biliard')->get();
        $meja = meja::orderBy('id_meja')->get();
        return view('dashboard.index', compact('mejabiliard','meja'));

    }
    public function store()
    {
        
    }
}

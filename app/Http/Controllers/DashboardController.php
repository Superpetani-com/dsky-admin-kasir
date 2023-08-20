<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MejaBiliard;
use App\Models\Meja;
use App\Models\OrderBiliard;
use App\Models\Pesanan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $mejabiliard = mejabiliard::with('order')
        ->orderBy('id_meja_biliard')->get();
        $meja = meja::with('pesanan')
        ->orderBy('id_meja')->get();

        // Get the user by their ID
        $user = User::find(auth()->user()->id);

        // Update the updated_at timestamp to the current date and time
        $user->update(['updated_at' => now()]);

        if(auth()->user()->level == 5 || auth()->user()->level == 6) {
            return redirect()->to('meja');
        }

        if(auth()->user()->level == 4) {
            return redirect()->to('menu');
        }

        if(auth()->user()->level == 3) {
            return redirect()->to('sensor');
        }

        return view('dashboard.index', compact('mejabiliard','meja'));
    }
    public function store()
    {

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MejaBiliard;
use App\Models\Meja;
use App\Models\OrderBiliard;
use App\Models\OrderBiliardDetail;
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

        if(auth()->user()->level == 2) {
            return redirect()->to('laporan');
        }

        foreach ($mejabiliard as $value) {
            $detail = OrderBiliardDetail::where('id_order_biliard', '=', $value->id_order_biliard)->get();
            foreach ($detail as $item) {
                if($item->flag == 1) {
                    $value->id_order_biliard_detail = $item->id_order_biliard_detail;
                    $value->id_meja = $item->id_meja;
                    $value->seting = $item->seting;
                }
            }

            // dd($value);

        }

        // dd($mejabiliard);

        return view('dashboard.index', compact('mejabiliard','meja'));
    }

    public function indexDataMeja()
    {
        $state = meja::with('pesanan')
        ->orderBy('id_meja')->get();

        return datatables()
            ->of($state)
            ->make(true);
    }

    public function indexDataMejaBill()
    {
        $state = mejabiliard::with('order')
        ->orderBy('id_meja_biliard')->get();

        return datatables()
            ->of($state)
            ->make(true);
    }


    public function store()
    {

    }
}

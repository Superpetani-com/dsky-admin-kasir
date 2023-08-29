<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MejaBiliard;
use App\Models\OrderBiliard;
use App\Models\OrderBiliardDetail;

class MejaBiliardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mejabiliard = mejabiliard::orderBy('id_meja_biliard')->get();
        return view('mejabiliard.index', compact('mejabiliard'));

    }
    public function data()
    {
        $mejabiliard=mejabiliard::orderBy('id_meja_biliard')->with('orderDetail')->get();
        // dd($mejabiliard);
        return datatables()
            ->of($mejabiliard)
            ->addIndexColumn()
            ->addColumn('jammulai', function ($mejabiliard) {
                if($mejabiliard->jammulai<>0){
                $tanggal=tanggal_indonesia($mejabiliard->jammulai, false);
                $waktu=substr($mejabiliard->jammulai, 11, 8);
                return $tanggal.' '.$waktu;}
                else{
                return '0';
                }
            })
            ->addColumn('jamselesai', function ($mejabiliard) {
                if($mejabiliard->jamselesai<>0){
                $tanggal=tanggal_indonesia($mejabiliard->jamselesai, false);
                $waktu=substr($mejabiliard->jamselesai, 11, 8);
                return $tanggal.' '.$waktu;
                }
                else{
                return '0';
                }
            })
            ->addColumn('durasi', function ($mejabiliard) {
                if($mejabiliard->flag>0){
                return ($mejabiliard->durasi).' Menit'.'+MAN';}
                if($mejabiliard->flag==0){
                return ($mejabiliard->durasi).' Menit';}
            })
            ->addColumn('sisadurasi', function ($mejabiliard) {
                return ($mejabiliard->sisadurasi).' Menit';
            })
            ->addColumn('status', function ($mejabiliard) {
                if ($mejabiliard->status=='Kosong'){
                    return '<div class="div-green">Kosong</div>';
                }
                elseif ($mejabiliard->status=='Dipakai'){
                    return '<div class="div-red">Dipakai</div>';
                }
                elseif ($mejabiliard->status=='Bayar'){
                    return '<div class="div-blue">Bayar</div>';
                }
            })
            ->addColumn('aksi', function($mejabiliard){
                if(auth()->user()->level == 2) {
                    return '';
                }else {
                    return '
                <div class="btn-group">
                   <button onclick="editForm(`'.route('orderbiliarddetail.index2', $mejabiliard->id_order_biliard).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"> </i> Detail</button>
                </div>
                <div class="btn-group">
                <button onclick="resetform(`'.route('mejabiliard.reset', $mejabiliard->id_meja_biliard).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Selesai</button>
                </div>
                   ';
                }
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function updatetime()
    {
        $mejabiliard=mejabiliard::orderBy('id_meja_biliard', 'desc')
        ->get();

        foreach ($mejabiliard as $item) {
        $durasi1=0;
        $detail = orderbiliarddetail::where('id_order_biliard',$item->id_order_biliard)->get();
        foreach ($detail as $itemd){
                $timenow = strtotime("now");
                $durasi1+=$itemd->menit;
                if ($itemd->flag==1){
                    $itemd->menit= ($timenow-(strtotime($itemd->created_at)))/60;
                    $itemd->jumlah= number_format($itemd->menit/60,2);
                    $itemd->subtotal= $itemd->jumlah*$itemd->harga;
                    $itemd->update();
                }
                if ($item->flag>0){
                    $jamselesai= date("Y/m/d H:i:s",intval(($durasi1*60)+(strtotime($item->jammulai))));
                    $item->jamselesai = $jamselesai;
                    $item->sisadurasi = 99999;
                }
                $item->durasi = number_format($durasi1,2,",",".");
        }


        if(strtotime("now")>strtotime($item->jamselesai)){

        if ($item->id_order_biliard!=0 and $item->flag==0 ){
            $item->status = "Bayar";
            //$order = orderbiliard::findOrFail($item->id_order_biliard);
            //$order->status="Selesai";
            //$order->update();
        }

        elseif ($item->id_order_biliard==0) {
            $item->status = "Kosong";
        }

        if ($item->flag==0){
            //$item->jammulai = 0;
            //$item->durasi = 0;
            $item->sisadurasi = 0;
           //$item->jamselesai = 0;
        }
        }

        elseif (strtotime("now")<strtotime($item->jamselesai) and $item->flag==0) {
            $selesai=(strtotime($item->jamselesai)-strtotime("now"))/60;
            $item->sisadurasi=number_format($selesai,2,",",".");
            $item->status="Dipakai";
        }
        $item->update();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        //return redirect()->route('orderbiliard.index', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    public function reset($id)
    {
        $mejabiliard = MejaBiliard::find($id);
        $order = orderbiliard::find($mejabiliard->id_order_biliard);
        $order->status="Selesai";
        $order->update();
        $mejabiliard->status = "Kosong";
        $mejabiliard->jammulai = 0;
        $mejabiliard->durasi = 0;
        $mejabiliard->sisadurasi = 0;
        $mejabiliard->jamselesai = 0;
        $mejabiliard->id_order_biliard = 0;
        $mejabiliard->flag = 0;
        $mejabiliard->update();
    }

    public function pindah($baru, $lama, $order)
    {
        $mejabiliard1 = MejaBiliard::find($lama);
        $mejabiliard2 = MejaBiliard::find($baru);
        $orderbiliard = OrderBiliard::find($mejabiliard1->id_order_biliard);
        $mejabiliard2->jammulai     =$mejabiliard1->jammulai;
        $mejabiliard2->durasi       =$mejabiliard1->durasi;
        $mejabiliard2->sisadurasi   =$mejabiliard1->sisadurasi;
        $mejabiliard2->jamselesai   =$mejabiliard1->jamselesai;
        $mejabiliard2->id_order_biliard   =$mejabiliard1->id_order_biliard;
        $mejabiliard2->status       =$mejabiliard1->status;
        $mejabiliard2->flag         =$mejabiliard1->flag;
        $mejabiliard2->update();
        $mejabiliard1->jammulai     =0;
        $mejabiliard1->durasi       =0;
        $mejabiliard1->sisadurasi   =0;
        $mejabiliard1->jamselesai   =0;
        $mejabiliard1->id_order_biliard   =0;
        $mejabiliard1->status       ="Kosong";
        $mejabiliard1->flag         =0;
        $mejabiliard1->update();

        $orderbiliard->id_meja_biliard=$baru;

        $orderbiliard->update();
        return redirect()->route('dashboard.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderBiliard;
use App\Models\OrderBiliardDetail;
use App\Models\MejaBiliard;
use App\Models\PaketBiliard;

class OrderBiliardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orderbiliard.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $order=new orderbiliard();
        $order->id_meja_biliard=$id;
        $order->totaljam=0.00;
        $order->totalharga=0.00;
        $order->totalbayar=0.00;
        $order->diterima=0;
        $order->kembali=0.00;
        $order->diskon=0;
        $order->totalflag=0;
        $order->status='Aktif';
        $order->save();
        return redirect()->route('orderbiliarddetail.index2', $order->id_order_biliard);
    }

    public function data()
    {
        $order=orderbiliard::with('meja')
        ->orderBy('id_order_biliard', 'desc')
        ->get();
        return datatables()
            ->of($order)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($order) {
            $tanggalid=tanggal_indonesia($order->created_at, false);
            //$tanggal=substr($order->created_at, 11, 8);
            $waktu=substr($order->created_at, 11, 5);
            return $tanggalid.' '.$waktu;
            })
            ->addColumn('totalharga', function ($order) {
                return 'Rp.'.format_uang($order->totalharga);
            })
            ->addColumn('totalbayar', function ($order) {
                return 'Rp.'.format_uang($order->totalbayar);
            })
            ->addColumn('diterima', function ($order) {
                return 'Rp.'.format_uang($order->diterima);
            })
            ->addColumn('kembali', function ($order) {
                return 'Rp.'.format_uang($order->kembali);
            })
            ->addColumn('meja', function ($order) {
                return $order->meja['namameja'];
            })
            ->addColumn('status', function ($order) {
                if ($order->status=='Aktif'){
                    return '<div class="div-red">Aktif</div>';  
                }
                elseif ($order->status=='Selesai'){
                    return '<div class="div-green">Selesai</div>';  
                }
            })
            ->addColumn('aksi', function($order){
                if (auth()->user()->level==2){return '
                <div class="btn-group">
                   <button onclick="editForm(`'.route('orderbiliarddetail.index2', $order->id_order_biliard).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"> </i> Edit</button>
                   <button onclick="deleteData(`'.route('orderbiliard.destroy', $order->id_order_biliard).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"> </i> Hapus</button>
                </div>
                   ';}
                if (auth()->user()->level==1){return '
                <div class="btn-group">
                       <button onclick="editForm(`'.route('orderbiliarddetail.index2', $order->id_order_biliard).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"> </i> Edit</button>
                </div>
                       ';}
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $mejabiliard = MejaBiliard::find($request->id_meja_biliard);
        $order = orderbiliard::findOrFail($request->id_order_biliard);
        $updatestatus = orderbiliard::where('id_meja_biliard',$request->id_meja_biliard)
        ->orderBy('id_order_biliard', 'desc')
        ->offset(1)
        ->limit(20)
        ->get();
        foreach ($updatestatus as $item){
        $item->status="Selesai";
        $item->update();}
        $order->totaljam= $request->total_jam;
        //$order->totalflag= $request->total_flag;
        $order->diskon = 0;
        $order->totalharga = $request->total;
        $order->totalbayar = $request->bayar;
        $order->diterima=$request->diterima;
        $order->kembali=$request->kembali;
        $order->customer=$request->nama_cust2;
        $order->update();

        if ($order->status=="Aktif"){
        $unixtimenow = strtotime("now");
        $timenow = date("Y/m/d H:i:s", $unixtimenow);
        $durasi=($request->total_menit);

        if ($mejabiliard->jammulai==0 && $mejabiliard->id_order_biliard==0){
            $mejabiliard->jammulai = $timenow;}
        //bila ada penambahan paket
        //if ($mejabiliard->jammulai!=0 && $mejabiliard->id_order_biliard!=0) {
        $jamselesai= date("Y/m/d H:i:s",intval(($durasi*60)+(strtotime($mejabiliard->jammulai))));
        $mejabiliard->jamselesai = $jamselesai;
        //}
        
        //bila paket baru
        /*if ($mejabiliard->jammulai==0 && $mejabiliard->id_order_biliard==0){
        $mejabiliard->jammulai = $timenow;
        $jamselesai= date("Y/m/d H:i:s",intval($durasi*60+$unixtimenow));
        $mejabiliard->jamselesai = $jamselesai;
        }*/

        $mejabiliard->durasi = number_format($durasi,2,",",".");        
        $mejabiliard->id_order_biliard = $request->id_order_biliard;
        $mejabiliard->flag=$request->total_flag;

        if(strtotime($mejabiliard->jamselesai)>strtotime("now") or $mejabiliard->flag>0){
            $mejabiliard->status = "Dipakai";
        }
        if ($mejabiliard->flag==0){
            $selesai=(strtotime($mejabiliard->jamselesai)-strtotime("now"))/60;
            if ($selesai<0){$selesai=0;}
            $mejabiliard->sisadurasi = number_format($selesai,2,",",".");
        }
        if ($mejabiliard->flag>0){
            $mejabiliard->sisadurasi = 99999;
        }
        $mejabiliard->update();
        }

        return redirect()->route('dashboard.index');
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
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order=OrderBiliard::find($id);
        $order->delete();

        return response(null, 204);
    }
    public function cetak($id)
    {
        $detail=OrderBiliardDetail::with('paket')
        ->where('id_order_biliard', $id)
        ->get();
        $order=OrderBiliard::where('id_order_biliard', $id)->first();
        //return ($detail);
        return view('orderbiliard.cetak', compact('detail','order'));
    }
    
}

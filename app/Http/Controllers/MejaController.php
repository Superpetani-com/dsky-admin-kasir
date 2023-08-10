<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Menu;

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meja = meja::orderBy('id_meja')->get();
        // dd('test');
        return view('meja.index', compact('meja'));
    }
    public function data()
    {
        $meja = meja::orderBy('id_meja')->get();

        if(auth()->user()->level == 5) {
            $meja = meja::where('Id_pesanan', '!=', '0')->with('pesanan_detail')->orderBy('id_meja')->get();
            // dd($meja['pesanan_detail'][0]);
            foreach ($meja as $value) {
                foreach ($value['pesanan_detail'] as $item) {
                    $menu = menu::where('Id_Menu', '=', $item['id_menu'])->get()[0];
                    $item['Nama_menu'] = $menu['Nama_menu'];
                }

                // dd($value['status']);
                if($value['Status'] == 'Dipakai') {
                    $value['Status'] = 'Menunggu Kitchen';
                }
                
                # code...
            }
            // dd($meja);
        } else {
            // $meja = meja::where('Id_pesanan', '!=', '0')->with('pesanan_detail')->orderBy('id_meja')->get();
            // dd($meja['pesanan_detail'][0]);
            foreach ($meja as $value) {
                

                // dd($value['status']);
                if($value['Status'] == 'Dipakai') {
                    $value['Status'] = 'Menunggu Kitchen';
                }
                
                # code...
            }
        }

        return datatables()
            ->of($meja)
            ->addIndexColumn()
            ->addColumn('status', function ($meja) {
                // dd($meja);
                if ($meja->Status=='Kosong'){
                    return '<div class="div-red">Kosong</div>';  
                } else if ($meja->Status=='Dipakai'){
                    return '<div class="div-green">Sedang Diproses</div>';  
                } else if ($meja->Status=='Menunggu Kitchen'){
                    return '<div class="div-green">Menunggu Kitchen</div>';  
                }

                if($meja->Status == "Selesai Kitchen") {
                    return '<div class="div-green">Selesai Kitchen</div>';  
                }
                if($meja->Status == "Diproses") {
                    return '<div class="div-green">Diproses Kitchen</div>';  
                }
            })
            ->addColumn('aksi', function($meja){
                if(auth()->user()->level == 6) {
                    return '';
                }
                if(auth()->user()->level == 5) {
                    if($meja->Status == "Diproses") {
                        return '
                        <div class="btn-group">
                            <button disabled onclick="prosesform(`'.route('meja.proses', $meja->id_meja).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Diproses</button>
                            <button onclick="resetform(`'.route('meja.reset', $meja->id_meja).'`)" class="btn btn-xs btn-success btn-flat">Selesai</button>
                            <button disabled onclick="cancelform(`'.route('meja.cancel', $meja->id_meja).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                        </div>
                    ';
                    }

                    if($meja->Status == "Selesai Kitchen") {
                        return '
                        <div class="btn-group">
                            <button disabled onclick="prosesform(`'.route('meja.proses', $meja->id_meja).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Diproses</button>
                            <button disabled onclick="resetform(`'.route('meja.reset', $meja->id_meja).'`)" class="btn btn-xs btn-success btn-flat">Selesai</button>
                            <button disabled onclick="cancelform(`'.route('meja.cancel', $meja->id_meja).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                        </div>
                    ';
                    }

                    if($meja->Status == "Menunggu Kitchen") {
                        return '
                        <div class="btn-group">
                            <button onclick="prosesform(`'.route('meja.proses', $meja->id_meja).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Diproses</button>
                            <button disabled onclick="resetform(`'.route('meja.reset', $meja->id_meja).'`)" class="btn btn-xs btn-success btn-flat">Selesai</button>
                            <button onclick="cancelform(`'.route('meja.cancel', $meja->id_meja).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                        </div>
                    ';
                    }

                    return '
                    <div class="btn-group">
                        <button onclick="prosesform(`'.route('meja.proses', $meja->id_meja).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Diproses</button>
                        <button onclick="resetform(`'.route('meja.reset', $meja->id_meja).'`)" class="btn btn-xs btn-success btn-flat">Selesai</button>
                        <button onclick="cancelform(`'.route('meja.cancel', $meja->id_meja).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                    </div>
                   ';
                        
                } else {
                    if($meja->Status == "Menunggu Kitchen") {
                        return '
                        <div class="btn-group">
                        <button onclick="editForm(`'.route('pesanandetail.index2', $meja->Id_pesanan).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"> </i> Edit</button>
                        <button disabled onclick="resetform(`'.route('meja.reset', $meja->id_meja).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Selesai</button>
                        <button onclick="cancelform(`'.route('meja.cancel', $meja->id_meja).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                        </div>
                    ';
                    }
                    return '
                    <div class="btn-group">
                        <button onclick="editForm(`'.route('pesanandetail.index2', $meja->Id_pesanan).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"> </i> Edit</button>
                        <button onclick="resetform(`'.route('meja.reset', $meja->id_meja).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Selesai</button>
                        <button onclick="cancelform(`'.route('meja.cancel', $meja->id_meja).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                    </div>
                   ';
                }

            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
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
        $meja=new meja();
        $meja = meja::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meja=meja::find($id);

        return response()->json($meja);
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
        $meja = meja::find($id);
        $meja->nama_meja = $request->nama_meja;
        $meja->Status=$request->Status;
        $meja->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meja = meja::find($id);
        $meja->delete();

        return response(null, 204);
    }

    public function reset($id)
    {
        $meja = meja::find($id);
        $pesanan = pesanan::find($meja->Id_pesanan);
        $detail = Pesanandetail::where('id_pesanan',$meja->Id_pesanan)->get();

        $pesanan->status="Selesai";

        if(auth()->user()->level == 5) {
            $pesanan->status="Selesai Kitchen";
            $meja->Status = "Selesai Kitchen";
        } else {
            $meja->Id_pesanan = 0;
            $meja->Status = "Kosong";
        }

        $pesanan->update();
        $meja->update();

        if(auth()->user()->level != 5) {
            foreach ($detail as $item2){
                $menu=menu::find($item2->id_menu);
                if($menu->jenis=="Update Stok" && $menu->stok>0 && $pesanan->status!="Selesai"){
                    $menu->stok=$menu->stok-$item2->jumlah;
                    $menu->update();
                }
            }
        }
    }

    public function cancel($id)
    {
        $meja = meja::find($id);
        $pesanan = pesanan::find($meja->Id_pesanan);
        $detail = Pesanandetail::where('id_pesanan',$meja->Id_pesanan)->get();

        if(auth()->user()->level == 5) {
            $pesanan->status="Selesai";
            $meja->Id_pesanan = 0;
            $meja->Status = "Kosong";
        } else {
            $meja->Id_pesanan = 0;
            $meja->Status = "Kosong";
        }

        $pesanan->update();
        $meja->update();
    }

    public function proses($id)
    {
        $meja = meja::find($id);
        $pesanan = pesanan::find($meja->Id_pesanan);
        $detail = Pesanandetail::where('id_pesanan',$meja->Id_pesanan)->get();

        if(auth()->user()->level == 5) {
            $pesanan->status="Diproses";
            $meja->Status = "Diproses";
        }

        $pesanan->update();
        $meja->update();
    }
}

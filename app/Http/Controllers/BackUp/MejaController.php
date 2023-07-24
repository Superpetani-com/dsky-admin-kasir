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
        return view('meja.index', compact('meja'));
    }
    public function data()
    {
        $meja=meja::orderBy('id_meja')->get();

        return datatables()
            ->of($meja)
            ->addIndexColumn()
            ->addColumn('status', function ($meja) {
                if ($meja->Status=='Kosong'){
                    return '<div class="div-green">Kosong</div>';  
                }
                elseif ($meja->Status=='Dipakai'){
                    return '<div class="div-red">Dipakai</div>';  
                }
            })
            ->addColumn('aksi', function($meja){
                return '
                <div class="btn-group">
                <button onclick="editForm(`'.route('pesanandetail.index2', $meja->Id_pesanan).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"> </i> Edit</button>
                <button onclick="resetform(`'.route('meja.reset', $meja->id_meja).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Selesai</button>
                </div>
                   ';
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
        $pesanan=pesanan::find($meja->Id_pesanan);
        $detail =Pesanandetail::where('id_pesanan',$meja->Id_pesanan)->get();
        $pesanan->status="Selesai";
        $pesanan->update();
        $meja->Status = "Kosong";
        $meja->Id_pesanan = 0;
        $meja->update();
        foreach ($detail as $item2){
            $menu=menu::find($item2->id_menu);
            if($menu->jenis=="Update Stok" && $menu->stok>0 && $pesanan->status!="Selesai"){
                $menu->stok=$menu->stok-$item2->jumlah;
                $menu->update();
            }
            }
        
    }
}

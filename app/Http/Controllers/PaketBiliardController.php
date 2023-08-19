<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketBiliard;

class PaketBiliardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paketbiliard.index');
    }

    public function data()
    {
        $paket=paketbiliard::orderBy('id_paket_biliard', 'desc')->get();

        return datatables()
            ->of($paket)
            ->addIndexColumn()
            ->addColumn('harga', function($paket){
                return 'Rp.'.format_uang($paket->harga);
            })

            ->addColumn('aksi', function($paket){
                if (auth()->user()->level==2  || auth()->user()->level==3 || auth()->user()->level==4){return '
                <div class="btn-group">
                   <button onclick="editForm(`'.route('paketbiliard.update', $paket->id_paket_biliard).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil icon"></i> Edit</button>
                   <button onclick="deleteData(`'.route('paketbiliard.destroy', $paket->id_paket_biliard).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash icon"></i> Hapus</button>
                </div>
                   ';}
            })
            ->rawColumns(['aksi'])
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
        $paket = new paketbiliard();
        $paket = paketbiliard::create($request->all());

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
        $paket=paketbiliard::find($id);

        return response()->json($paket);
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
        $paket = paketbiliard::find($id);
        $paket->nama_paket = $request->nama_paket;
        $paket->harga=$request->harga;
        $paket->keterangan=$request->keterangan;
        $paket->durasi=$request->durasi;
        $paket->type=$request->type;
        $paket->update();

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
        $paket = paketbiliard::find($id);
        $paket->delete();

        return response(null, 204);
    }
}

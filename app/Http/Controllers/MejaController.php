<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Menu;
use App\Models\OrderBiliard;
use App\Models\MejaBiliard;


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

    public function dataPesanan()
    {
        $pesanan = pesanan::where('status', '!=', 'selesai')->with('meja', 'pesananDetail', 'meja_biliard')->orderBy('created_at', 'desc')->groupBy('Id_meja')->get();

        if(auth()->user()->level == 5) {
            $pesanan = pesanan::where('status', '!=', 'selesai')->where('TotalItem', '>', '0')->with('meja', 'pesananDetail', 'meja_biliard')->orderBy('created_at', 'desc')->groupBy('Id_meja')->get();
        }
        foreach ($pesanan as $value) {
            $order = orderbiliard::where('id_pesanan', '=', $value->Id_pesanan)->get();
            // dd($order);
            $value->isOrder = false;
            if(count($order) > 0) {
                // dd($value);
                $value->namas_meja = '[Biliard]'. strval($value->Id_meja);
                $value->isOrder = true;
            }
            foreach ($value->pesananDetail as $item) {
                // dd($value['pesananDetail']);

                if($item->id_menu) {
                    // dd($item->id_menu);
                    $menu = menu::where('Id_Menu', '=', $item->id_menu)->get()[0];
                    // dd($menu);
                    $item->Nama_menu = $menu['Nama_menu'];
                }

            }
        }


        return datatables()
            ->of($pesanan)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($pesanan) {
            $tanggalid=tanggal_indonesia($pesanan->created_at, false);
            //$tanggal=substr($order->created_at, 11, 8);
            $waktu=substr($pesanan->created_at, 11, 5);
            return $tanggalid.' '.$waktu;
            })
            ->addColumn('meja', function ($pesanan) {
                if($pesanan->meja) {
                    return $pesanan->meja->nama_meja;
                }
            })
            ->addColumn('status', function ($order) {
                if ($order->status=='Aktif'){
                    return '<div class="div-red">Aktif</div>';
                }
                elseif ($order->status=='Selesai'){
                    return '<div class="div-green">Selesai</div>';
                }
            })
            ->addColumn('aksi', function($pesanan){
                if (auth()->user()->level==3){return '
                <div class="btn-group">
                   <button onclick="editForm(`'.route('pesanandetail.index2', $pesanan->Id_pesanan).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"> </i> Edit</button>
                   <button onclick="deleteData(`'.route('pesanan.destroy', $pesanan->Id_pesanan).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"> </i> Hapus</button>
                </div>
                   ';}
                if (auth()->user()->level==1){return '
                    <div class="btn-group">
                       <button onclick="editForm(`'.route('pesanandetail.index2', $pesanan->Id_pesanan).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"> </i> Edit</button>
                    </div>
                       ';}
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function data()
    {
        $meja = meja::orderBy('id_meja')->get();

        if(auth()->user()->level == 5) {
            $meja = meja::where('Id_pesanan', '!=', '0')->where('status', '=', 'Diproses')->with('pesanan_detail', 'pesanan')->orderBy('id_meja')->get();
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
                if(auth()->user()->level == 6 || auth()->user()->level == 4 || auth()->user()->level == 2) {
                    return '';
                }
                if(auth()->user()->level == 5) {
                    if($meja->Status == "Diproses") {
                        return '
                        <div class="btn-group">
                            <button disabled class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Diproses</button>
                            <button onclick="resetform(`'.route('meja.reset', $meja->id_meja).'`)" class="btn btn-xs btn-success btn-flat">Selesai</button>
                            <button disabled class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                        </div>
                    ';
                    }

                    if($meja->Status == "Selesai Kitchen") {
                        return '
                        <div class="btn-group">
                            <button disabled class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Diproses</button>
                            <button disabled class="btn btn-xs btn-success btn-flat">Selesai</button>
                            <button disabled class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                        </div>
                    ';
                    }

                    if($meja->Status == "Menunggu Kitchen") {
                        return '
                        <div class="btn-group">
                            <button onclick="prosesform(`'.route('meja.proses', $meja->id_meja).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Diproses</button>
                            <button disabled class="btn btn-xs btn-success btn-flat">Selesai</button>
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
                        <button disabled class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Selesai</button>
                        <button onclick="cancelform(`'.route('meja.cancel', $meja->id_meja).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                        </div>
                    ';
                    }

                    if($meja->Status == "Kosong") {
                        return '
                        <div class="btn-group">
                        <button disabled onclick="editForm(`'.route('pesanandetail.index2', $meja->Id_pesanan).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"> </i> Edit</button>
                        <button disabled class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Selesai</button>
                        <button disabled onclick="cancelform(`'.route('meja.cancel', $meja->id_meja).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
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

    public function dataDiproses()
    {
        $meja = meja::orderBy('id_meja')->get();

        if(auth()->user()->level == 5) {
            $meja = meja::where('Id_pesanan', '!=', '0')->where('status', '=', 'Dipakai')->with('pesanan_detail', 'pesanan')->orderBy('id_meja')->get();
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
                if(auth()->user()->level == 6 || auth()->user()->level == 4 || auth()->user()->level == 2) {
                    return '';
                }
                if(auth()->user()->level == 5) {
                    if($meja->Status == "Diproses") {
                        return '
                        <div class="btn-group">
                            <button disabled class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Diproses</button>
                            <button onclick="resetform(`'.route('meja.reset', $meja->id_meja).'`)" class="btn btn-xs btn-success btn-flat">Selesai</button>
                            <button disabled class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                        </div>
                    ';
                    }

                    if($meja->Status == "Selesai Kitchen") {
                        return '
                        <div class="btn-group">
                            <button disabled class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Diproses</button>
                            <button disabled class="btn btn-xs btn-success btn-flat">Selesai</button>
                            <button disabled class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                        </div>
                    ';
                    }

                    if($meja->Status == "Menunggu Kitchen") {
                        return '
                        <div class="btn-group">
                            <button onclick="prosesform(`'.route('meja.proses', $meja->id_meja).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Diproses</button>
                            <button disabled class="btn btn-xs btn-success btn-flat">Selesai</button>
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
                        <button disabled class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Selesai</button>
                        <button onclick="cancelform(`'.route('meja.cancel', $meja->id_meja).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
                        </div>
                    ';
                    }

                    if($meja->Status == "Kosong") {
                        return '
                        <div class="btn-group">
                        <button disabled onclick="editForm(`'.route('pesanandetail.index2', $meja->Id_pesanan).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"> </i> Edit</button>
                        <button disabled class="btn btn-xs btn-danger btn-flat"><i class="fa fa-book"> </i> Selesai</button>
                        <button disabled onclick="cancelform(`'.route('meja.cancel', $meja->id_meja).'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-close"> </i> Cancel</button>
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

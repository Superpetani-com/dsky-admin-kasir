<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Meja;
use App\Models\PesananDetail;
use App\Models\Menu;
use Ramsey\Uuid\Uuid;

class PesananController extends Controller
{
    public function index()
    {
        $meja=meja::orderBy('id_meja', 'desc')->get();
        return view('pesanan.index', compact('meja'));
    }

    public function create($id)
    {
        $uuid = Uuid::uuid4();
        $pesanan=new pesanan();
        $pesanan->Id_meja=$id;
        $pesanan->TotalItem=0;
        $pesanan->TotalHarga=0;
        $pesanan->Diskon=0;
        $pesanan->TotalBayar=0;
        $pesanan->Diterima=0;
        $pesanan->Kembali=0;
        $pesanan->ppn=10;
        $pesanan->status='Aktif';
        $pesanan->cabang_id='Jogja Billiard';
        $pesanan->created_by = auth()->user()->name;
        $pesanan->uuid = $uuid->toString();
        $pesanan->save();
        //session(['Id_pesanan'=> $pesanan->Id_pesanan]);
        //session(['Id_meja'=> $pesanan->Id_meja]);
        //dd($pesanan->Id_pesanan);
        return redirect()->route('pesanandetail.index2', $pesanan->Id_pesanan);
    }

    public function data()
    {
        $pesanan = pesanan::with('meja')
        ->orderBy('Id_pesanan', 'desc')
        ->get();
        // dd($pesanan);
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


    public function store(request $request)
    {
        // dd($request);
        $pesanan = Pesanan::findOrFail($request->id_pesanan);
        $updatestatus = Pesanan::where('Id_meja',$request->id_meja_cafe)
        ->orderBy('Id_pesanan', 'desc')
        ->offset(1)
        ->limit(20)
        ->get();
        //return [$updatestatus, $pesanan];
        // dd($request);
        foreach ($updatestatus as $item){
        $item->status="Selesai";
        $item->update();}
        $pesanan->TotalItem= $request->total_item;
        $pesanan->TotalHarga = $request->total;
        $pesanan->Diskon = 0;
        $pesanan->TotalBayar = $request->total;
        $pesanan->Diterima=$request->total;
        // $pesanan->Kembali=$request->kembali;
        $pesanan->Kembali=0;
        $pesanan->customer=$request->nama_cust2;
        $pesanan->ppn=$request->ppn;
        $pesanan->update();
        $meja=Meja::find($pesanan->Id_meja);
        if ($pesanan->status=="Aktif"){
            $meja->Status="Dipakai";
            $meja->Id_pesanan=$pesanan->Id_pesanan;
        }
        $meja->update();

        return
        redirect()->route('dashboard.index');
    }

    public function cetak($id)
    {
        $detail=PesananDetail::with('menu')
        ->where('id_pesanan', $id)
        ->get();
        $pesanan=pesanan::where('Id_pesanan', $id)->first();
        $meja=meja::where('id_meja', $pesanan->Id_meja)->first();
        $nama_meja=$meja->nama_meja;
        //return ($detail);
        return view('pesanan.cetak', compact('detail','pesanan', 'nama_meja'));
    }

    public function cetakreset($id)
    {
        $detail=PesananDetail::with('menu')
        ->where('id_pesanan', $id)
        ->get();
        $pesanan=pesanan::where('Id_pesanan', $id)->first();
        redirect()->route('meja.reset', $pesanan->Id_meja);
        return view('pesanan.cetak', compact('detail','pesanan'));
    }

    public function destroy($id)
    {
        $pesanan = pesanan::find($id);
        $pesanan->delete();

        return response(null, 204);
    }
}

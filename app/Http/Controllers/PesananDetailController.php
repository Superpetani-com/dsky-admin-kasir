<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\LogHapus;
use Ramsey\Uuid\Uuid;

class PesananDetailController extends Controller
{
    /*public function index()
    {
        $Id_pesanan=$id;
        $menu=menu::orderBy('Nama_menu')->get();
        $pesanan=pesanan::where('Id_pesanan', $id)->first();
        $meja=$pesanan->Id_meja;
        if(!$meja){
            abort(404);
        }

        return view('pesanandetail.index', compact('Id_pesanan','menu','meja'));

    }*/

    public function index2($id)
    {
        if ($id==0){
            return "Belum Ada Order";
        }
        $Id_pesanan=$id;
        $menu=menu::orderBy('Nama_menu')->get();
        $pesanan=pesanan::where('Id_pesanan', $id)->first();
        $meja=meja::where('Id_meja', $pesanan->Id_meja)->first();

        return view('pesanandetail.index2', compact('Id_pesanan','menu','meja','pesanan'));

    }

    public function store(Request $request)
    {
        $menu = menu::where('Id_Menu', $request->id_menu)->first();
        if(!$menu){
            return response()->json('Data gagal disimpan', 400);
        }
        $detail= new PesananDetail();
        $detail->id_pesanan=$request->id_pesanan;
        $detail->id_menu=$menu->Id_Menu;
        $detail->harga=$menu->Harga;
        $detail->jumlah=1;
        $detail->subtotal=$menu->Harga;
        $detail->cabang_id='Jogja Billiard';
        $detail->save();
        return response()->json('Data berhasil disimpan', 200);
    }

    public function storeWithMeja(Request $request)
    {
        $menu = menu::where('Id_Menu', $request->id_menu)->first();
        if(!$menu){
            return response()->json('Data gagal disimpan', 400);
        }
        $detail= new PesananDetail();
        $detail->id_pesanan=$request->id_pesanan;
        $detail->id_menu=$menu->Id_Menu;
        $detail->harga=$menu->Harga;
        $detail->jumlah=1;
        $detail->subtotal=$menu->Harga;
        $detail->cabang_id='Jogja Billiard';
        $detail->save();
        return response()->json('Data berhasil disimpan', 200);
    }

    public function data($id, $status)
    {
        $detail=PesananDetail::with('menu')
        ->where('id_pesanan', $id)
        ->get();
        $data = array();
        $total = 0;
        $total_item = 0;
        foreach ($detail as $item) {
            $row = array();

            // total * ppn
            $item->subtotal = $item->subtotal;

            $row['nama_menu'] = $item->menu['Nama_menu'];
            $row['harga']       = 'Rp. '. format_uang($item->harga);
            if ( $status=="Selesai"){
                $row['jumlah']      = '<input type="number" class="form-control input-sm quantity-pesanan" data-id="'. $item->id_pesanan_detail .'" value="'. $item->jumlah .'" readonly>';
            }
            else{
                $row['jumlah']      = '<input type="number" class="form-control input-sm quantity-pesanan" data-id="'. $item->id_pesanan_detail .'" value="'. $item->jumlah .'">';
            }
            $row['subtotal']    = 'Rp. '. format_uang($item->subtotal);

            $row['aksi']        =  ' <div class="btn-group">
                                    <button onclick="deleteData(`'.route('pesanandetail.destroy', $item->id_pesanan_detail).'`)" class="btn btn-xs btn-danger btn-flat btn-hapus"><i class="fa fa-trash"></i> Hapus</button>
                                    </div>';
            $data[] = $row;
            // dd($item->harga);

            $total += $item->harga * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'nama_menu'=> '',
            'harga'=>'',
            'jumlah'=>'
            <div class="total hide">'. $total .'</div>
            <div class="total_item hide">'. $total_item .'</div>',
            'subtotal'=>'',
            'aksi'=>'',
                          ];
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'jumlah'])
            ->make(true);

        /*return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('nama_menu', function ($detail){
                return $detail->menu['Nama_menu'];
            })
            ->addColumn('harga', function ($detail){
                return 'Rp.'.$detail->harga;
            })
            ->addColumn('jumlah', function ($detail){
                return '<input type="number" class="form-control input-sm quantity" data-id="'.$detail->id_pesanan_detail.'"
                value="'.$detail->jumlah.'">';
            })
            ->addColumn('subtotal', function ($detail){
                return 'Rp.'.$detail->subtotal;
            })
            ->addColumn('aksi', function($detail){
                return '
                <div class="btn-group">
                   <button onclick="deleteData(`'.route('pesanandetail.destroy', $detail->id_pesanan_detail).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                </div>
                   ';
            })
            ->rawColumns(['aksi', 'jumlah'])
            ->make(true);*/
    }

    public function update(Request $request, $id)
    {
        $detail=pesanandetail::find($id);
        $detail->jumlah=$request->jumlah;
        $detail->subtotal=$detail->harga*$request->jumlah;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = pesanandetail::find($id);

        // save deleted data to table log_hapus
        $uuid = Uuid::uuid4();

        $log_hapus= new LogHapus();
        $log_hapus->id_pesanan = $detail->id_pesanan;
        $log_hapus->id_menu = $detail->id_menu;
        $log_hapus->harga = $detail->harga;
        $log_hapus->jumlah = $detail->jumlah;
        $log_hapus->subtotal = $detail->subtotal;
        $log_hapus->cabang_id = 'Jogja Billiard';
        $log_hapus->user_id = auth()->user()->name;
        $log_hapus->created_at = date('Y-m-d H:i:s');
        $log_hapus->updated_at = date('Y-m-d H:i:s');
        $log_hapus->uuid = $uuid->toString();

        $log_hapus->save();

        $detail->delete();
        return response(null, 204);
    }

    public function loadform($diskon, $total, $diterima)
    {
        //0.1 karena ppn 10%
        $ppn=intval(0.1*$total);
        $bayar = $total;
        $kembali =$diterima - ceil($bayar / 100) * 100;
        $bayar = ceil($bayar / 100) * 100;
        // dd($bayar);
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'kembali'=>$kembali,
            'ppn'=>$ppn,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali). ' Rupiah'),
        ];
        return response()->json($data);
    }
}

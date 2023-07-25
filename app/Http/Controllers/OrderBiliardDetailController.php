<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderBiliard;
use App\Models\OrderBiliardDetail;
use App\Models\MejaBiliard;
use App\Models\PaketBiliard;
use App\Models\Meja;

class OrderBiliardDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function index2($id) //pertama isi data sebelum mulai hidupkan lampu
    {
        if ($id==0){
            return "Belum Ada Order";
        }
        $id_order_biliard=$id;
        $paket=paketbiliard::orderBy('nama_paket')->get();
        $order=orderbiliard::where('id_order_biliard', $id)->first();
        $mejabiliard=mejabiliard::where('id_meja_biliard', $order->id_meja_biliard)->first();
        $mejadetail = mejabiliard::orderBy('id_meja_biliard')->get();
        return view('orderbiliarddetail.index', compact('id_order_biliard','paket','order','mejabiliard', 'mejadetail'));
        
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
        $paket = paketbiliard::where('id_paket_biliard', $request->id_paket_biliard)->first();
        if(!$paket){
            return response()->json('Data gagal disimpan', 400);
        }
        $detail= new OrderBiliardDetail();
        if ($request->seting_paket=="AUTO"){
            $detail->jumlah =1.00;
            $detail->menit  =$detail->jumlah*$paket->durasi;
            $detail->flag   =0;

        }
        if ($request->seting_paket=="MANUAL"){
            $detail->jumlah =0.00;
            $detail->menit  =0.00;
            $detail->flag   =1;   
        }
        $detail->id_order_biliard=$request->id_order_biliard;
        $detail->id_paket_biliard=$paket->id_paket_biliard;
        $detail->harga=$paket->harga;
        $detail->seting =$request->seting_paket;
        $detail->subtotal=$paket->harga*$detail->jumlah;
        $detail->save();
        return response()->json('Data berhasil disimpan', 200);
    }
    
    public function data($id, $status1, $status2)
    {
        $detail=OrderBiliardDetail::with('paket', 'order')
        ->where('id_order_biliard', $id)
        ->get();
        // dd ($detail);
        $data = array();
        $total = 0;
        $total_jam = 0;
        $total_flag = 0;
        $total_menit= 0;
        
        
        foreach ($detail as $item) {
            // dd($item['order']['id_meja_biliard']);
            $mejabiliard=mejabiliard::where('id_meja_biliard', $item['order']['id_meja_biliard'])->first();


            $row = array();
            $row['nama_paket'] = $item->paket['nama_paket'];
            $row['harga']       = 'Rp. '. format_uang($item->harga);
            if ($status2=="Selesai" or $item->seting<>"AUTO"){
            $row['jumlah']      = 
            '<form>
            <div class="form-group">
            <input type="number" class="quantity form-control" onchange="checkInputValidity(this, '. $item->jumlah .')" max="'. $item->jumlah .'" data-id="'.$item->id_order_biliard_detail .'" value="'. $item->jumlah .'" step=".05" size="4" readonly>
            </div>
            </form>';   
            }
            else{
            $row['jumlah']      = 
            '<form>
            <div class="form-group">
            <input type="number" class="quantity form-control" onchange="checkInputValidity(this, '. $item->jumlah .')" max="'. $item->jumlah .'" data-id="'.$item->id_order_biliard_detail .'" value="'. $item->jumlah .'" step=".05" size="4">
            </div>
            </form>';
            }
            $row['subtotal']    = 'Rp. '. format_uang($item->subtotal);
            if ($status2<>"Selesai"){
                $row['aksi']        =  ' <div class="btn-group">
                                        <button onclick="deleteData(`'.route('orderbiliarddetail.destroy', $item->id_order_biliard_detail).'`)" class="btn btn-xs btn-danger btn-flat btn-hapus"><i class="fa fa-trash"></i> H</button>
                                        </div>'; 
            }
            if ($status2=="Selesai"){
                $row['aksi']        =  ' ';
            }
            if ($item->seting=="MANUAL"){
                $row['aksi2']        =  ' <div class="btn-group">
                                        <button onclick="stopseting('.$item->id_order_biliard_detail.')" class="btn btn-xs btn-warning btn-flat btn-stop"><i class="fa fa-ban"></i> S</button>
                                        </div>'; 
            }
            if ($item->seting<>"MANUAL"){
                $row['aksi2']        ='';

            }                       
            $row['menit']       = $item->menit;
            $row['seting']      = $item->seting;
            $row['durasi']      = $item->created_at;
            $row['sisadurasi']  = $mejabiliard['sisadurasi'] . ' Menit';
            $data[] = $row;

            $total += $item->harga * $item->jumlah;
            $total_jam  += $item->jumlah;
            $total_flag += $item->flag;
            $total_menit += $item->menit;
        } 
        $data[] = [
            'nama_paket'=> '',
            'harga'=>'',
            'jumlah'=>'
            <div class="total hide">'. $total .'</div>
            <div class="total_jam hide">'. $total_jam .'</div>,
            <div class="total_menit hide">'. $total_menit .'</div>,
            <div class="total_flag hide">'. $total_flag .'</div>',
            'menit'=>'',
            'seting'=>'',
            'subtotal'=>'',
            'aksi'=>'',
            'aksi2'=>'',
            'sisadurasi'=>''
                          ];
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'jumlah', 'aksi2'])
            ->make(true);

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
        $detail=OrderBiliardDetail::with('paket')->find($id);
        $detail->jumlah=$request->jumlah;
        $detail->menit=$request->jumlah*$detail->paket['durasi'];
        $detail->subtotal=$detail->harga*$request->jumlah;
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = OrderBiliardDetail::find($id);
        $isDeleted = false;
        // $orderAll = OrderBiliardDetail::where('id_order_biliard', $detail->id_order_biliard)->get();

        $valueToCheck = $detail->menit; // The value you want to check
        $columnToCheck = 'menit'; // The column in which you want to check the maximum value
        $maxValueInColumn = OrderBiliardDetail::where('id_order_biliard', $detail->id_order_biliard)->max($columnToCheck);

        if ($valueToCheck === $maxValueInColumn) {
            // The value is the maximum in the column
            // Your logic here
            $isDeleted = false;
        } else {
            // The value is not the maximum in the column
            // Your logic here
            $isDeleted = true;
        }

        // dd($isDeleted, $maxValueInColumn);
        if($isDeleted) {
            $detail->delete();
            return response(null, 204);
        } else {
            return response('failed delete', 500);
        }
 
    }

    public function stop($id, $meja, $flag)
    {
        $total_flag = 0;
        $detail = OrderBiliardDetail::find($id);
        $detail->seting="STOP";
        $detail->flag   =0;
        $detail->update();
        $detail1=OrderBiliardDetail::where('id_order_biliard', $detail->id_order_biliard)
        ->get();
        foreach ($detail1 as $item) {
        $total_flag += $item->flag;
        } 
        $meja = Mejabiliard::find($meja);
        $meja->flag=$total_flag;
        $meja->update();
        return response(null, 204);
    }

    public function loadform($diskon, $total, $diterima)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $kembali =$diterima - $bayar;
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'kembali'=>$kembali,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali). ' Rupiah'),
        ];
        return response()->json($data);
    }
}

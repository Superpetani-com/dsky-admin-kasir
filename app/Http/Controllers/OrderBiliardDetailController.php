<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderBiliard;
use App\Models\OrderBiliardDetail;
use App\Models\MejaBiliard;
use App\Models\PaketBiliard;
use App\Models\PesananDetail;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\Menu;
use DateTime;
use DateInterval;

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

        $currentHour = date('H'); // Get the current hour in 24-hour format (00 to 23)

        // Check if the current hour is within the range of 13:00 (1:00 PM) to 17:00 (5:00 PM)
        $paket = paketbiliard::whereIn('type', ['malam', 'custom'])->orderBy('id_paket_biliard', 'desc')->get();
        if ($currentHour >= 6 && $currentHour <= 17) {
            // The current time is within the range
            $paket = paketbiliard::whereIn('type', ['siang', 'custom'])->orderBy('id_paket_biliard', 'desc')->get();
        }

        $order=orderbiliard::where('id_order_biliard', $id)->first();
        $mejabiliard=mejabiliard::where('id_meja_biliard', $order->id_meja_biliard)->first();
        $mejadetail = mejabiliard::orderBy('id_meja_biliard')->get();
        $menu=menu::orderBy('Nama_menu')->get();

        if ($id==0){
            return "Belum Ada Order";
        }
        $Id_pesanan=$order->id_pesanan;

        if($Id_pesanan != 0) {
            $pesanan=pesanan::where('Id_pesanan', $order->id_pesanan)->first();
            $meja=meja::where('Id_meja', $pesanan->Id_meja)->first();
            $pesanan_detail = pesanandetail::where('id_pesanan', $order->id_pesanan)->get();

            $count_pesanan_detail = count($pesanan_detail);

            return view('orderbiliarddetail.index', compact('id_order_biliard','paket','order','mejabiliard', 'mejadetail','Id_pesanan','menu','meja','pesanan', 'count_pesanan_detail'));
        }


        return view('orderbiliarddetail.index', compact('id_order_biliard','paket','order','mejabiliard', 'mejadetail','Id_pesanan','menu'));

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
        // dd($request);
        $id_paket_custom = paketbiliard::select('id_paket_biliard')->where('type', 'custom')->get();
        $ids_paket_custom = [];
        foreach ($id_paket_custom as $key) {
            array_push($ids_paket_custom, $key['id_paket_biliard']);
        }

        $check_is_custom = OrderBiliardDetail::where('id_order_biliard', '=', $request->id_order_biliard)->whereIn('id_paket_biliard', $ids_paket_custom)->get();

        if(count($check_is_custom) > 0) {
            return response()->json('Hanya boleh 1 order custom', 400);
        }

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
        $detail->cabang_id='XT Billiard';
        $detail->save();
        return response()->json('Data berhasil disimpan', 200);
    }

    public function store_detail(Request $request){
        print_r("hehe");exit;
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
        $order->cabang_id='XT Billiard';
        $order->created_by = auth()->user()->name;

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
        $pesanan->cabang_id='XT Billiard';
        $pesanan->created_by = auth()->user()->name;
        $pesanan->uuid = $uuid->toString();
        $pesanan->save();

        $order->id_pesanan =  $pesanan->Id_pesanan;
        $order->save();
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
            // dd($item);
            // dd($item['order']['id_meja_biliard']);
            $mejabiliard=mejabiliard::where('id_meja_biliard', $item['order']['id_meja_biliard'])->first();

            // dd($item);
            $row = array();
            $row['nama_paket'] = $item->paket['nama_paket'];
            $row['harga']       = 'Rp. '. format_uang($item->harga);
            if ($status2=="Selesai" or $item->seting<>"AUTO"){
            $row['jumlah']      =
            '<form>
            <div class="form-group">
            <input disabled type="number" class="quantity form-control" onchange="checkInputValidity(this, '. $item->jumlah .')" max="'. $item->jumlah .'" data-id="'.$item->id_order_biliard_detail .'" value="'. $item->jumlah .'" step=".05" size="4" readonly>
            </div>
            </form>';
            }
            else{
            $row['jumlah']      =
            '<form>
            <div class="form-group">
            <input disabled type="number" class="quantity form-control" onchange="checkInputValidity(this, '. $item->jumlah .')" max="'. $item->jumlah .'" data-id="'.$item->id_order_biliard_detail .'" value="'. $item->jumlah .'" step=".05" size="4">
            </div>
            </form>';
            }


            $row['subtotal']    = 'Rp. '. format_uang(ceil($item->subtotal / 1000) * 1000);

            if ($status2<>"Selesai"){
                $row['aksi']        =  '<div class="btn-group">
                                        <button onclick="confirmDelete(`'.route('orderbiliarddetail.destroy', $item->id_order_biliard_detail).'`)" class="btn btn-xs btn-danger btn-flat btn-hapus" type="button"><i class="fa fa-trash"></i></button>
                                        <div>'
                                        ;
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

            $total += $item->harga * $item->jumlah;

            if(intval($mejabiliard->durasi) <= 60 && intval($mejabiliard->durasi) != 0 && $item->flag >0) {
                $row['subtotal'] = format_uang($item->harga);
                $total = $item->harga;
            }

            $row['menit']       = $item->menit;
            $row['seting']      = $item->seting;
            $row['durasi']      = $item->created_at;
            $row['sisadurasi']  = $mejabiliard['sisadurasi'] . ' Menit';
            $data[] = $row;
            $total_jam  += $item->jumlah;
            $total_flag += $item->flag;
            $total_menit += $item->menit;
        }

        $order = OrderBiliard::where('id_order_biliard', '=', $id)->first();
        $detail=PesananDetail::with('menu')
        ->where('id_pesanan', $order->id_pesanan)
        ->get();
        $totalpesanan = 0;
        $total_item = 0;
        foreach ($detail as $item) {
            $totalpesanan += $item->harga * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'nama_paket'=> '',
            'harga'=>'',
            'jumlah'=>'
            <div class="totalbil hide">'. ceil($total / 1000) * 1000 .'</div>
            <div class="total_jam hide">'. $total_jam .'</div>
            <div class="total_menit hide">'. $total_menit .'</div>
            <div class="total_flag hide">'. $total_flag .'</div>
            <div class="total_item hide">'. $total_item .'</div>',
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
        // dd($request);
        $detail=OrderBiliardDetail::with('paket')->find($id);
        $order = OrderBiliard::where('id_order_biliard', '=', $detail->id_order_biliard)->first();
        // dd($order);
        $mejabiliard = mejabiliard::where('id_meja_biliard', $order->id_meja_biliard)->first();
        $baru_main_berapa_menit = intval($detail->menit) - intval($mejabiliard->sisadurasi);
        $jumlah_menit_request_main = floatval($request->jumlah) * intval($detail->menit);

        // dd(intval($jumlah_menit_request_main) < $baru_main_berapa_menit);
        if(intval($jumlah_menit_request_main) < $baru_main_berapa_menit) {
            // $detail->delete();
            return response('failed delete', 500);
        }
        // dd($baru_main_berapa_menit);
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
        // dd($detail);
        $order = OrderBiliard::where('id_order_biliard', '=', $detail->id_order_biliard)->first();
        // dd($order);
        $mejabiliard = mejabiliard::where('id_meja_biliard', $order->id_meja_biliard)->first();
        $baru_main_berapa_menit = intval($detail->menit) - intval($mejabiliard->sisadurasi);
        // dd($baru_main_berapa_menit < 2);
        if($baru_main_berapa_menit < 2) {
            $detail->delete();
            return response(null, 204);
        }

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

        // dd($detail);
        // foreach ($detail1 as $item) {
        //     dd($item);
        //     $total_flag += $item->flag;
        // }
        // $meja = Mejabiliard::find($meja);
        // $meja->flag=$total_flag;
        // $meja->update();
        return response(null, 204);
    }

    public function loadform($diskon, $total, $diterima)
    {
        // dd($total);
        // $total += $total;
        $bayar = $total - ($diskon / 100 * $total);
        $kembali =$diterima - $bayar;
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'kembali'=>$kembali,
            'bayarrp' => $bayar,
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali). ' Rupiah'),
        ];
        return response()->json($data);
    }
}

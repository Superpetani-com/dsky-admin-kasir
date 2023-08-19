<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MejaBiliard;
use App\Models\LogSensor;
use App\Models\LogHapus;
use App\Models\PaketBiliard;
use App\Models\OrderBiliardDetail;
use App\Models\OrderBiliard;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DataLampuController extends Controller
{
    public function data()
    {
        $state=MejaBiliard::orderBy('id_meja_biliard')->get();
        $x=0;
        foreach ($state as $item) {
            if ($item->status=="Dipakai"){
                $data[$x] = 1;
            }
            else{
                $data[$x] = 0;
            }
            $x+=1;
        }
        return ($data);

    }

    public function store(Request $request) {
        if($request->id_meja == 1) {
            $request->id_meja = 0;
        }
        $state = MejaBiliard::where('id_meja_biliard', '=', $request->id_meja)->first();
        if($state) {
            if($state->status != "Dipakai" && $request->duration > 120) {
                // jika meja tidak sedang dipakai tapi lampu nyala, insert log
                $meja = new LogSensor();

                // get last order created_by
                $findLastOrderToGetUsers = OrderBiliard::orderBy('id_order_biliard', 'desc')->first()['created_by'];

                $data = [
                    'id_meja' => $request->id_meja,
                    'duration' => $request->duration,
                    'created_date' => date('Y-m-d H:i:s'),
                    'cabang_id' => 'Jogja Billiard',
                    'created_by' => $findLastOrderToGetUsers
                ];

                $meja = LogSensor::create($data);

                return response()->json(['code' => 200, 'message'=> 'Data berhasil disimpan', 'data' => $data], 200);
            }

            if($state->status == "Dipakai") {
                return response()->json(['code' => 500, 'message'=> 'Meja Sedang Dipakai', 'data' => []], 500);
            }

            if($request->duration < 120) {
                return response()->json(['code' => 500, 'message'=> 'Durasi Kurang Dari 120 detik', 'data' => []], 500);
            }
        }

        if(!$state) {
            return response()->json(['code' => 500, 'message'=> 'Id Meja Tidak Ditemukan', 'data' => []], 500);
        }

        return ($state);
    }

    public function getAll() {
        $state = LogSensor::with('meja')->orderBy('id', 'desc')->get();
        return view('laporan.sensor', compact('state'));
    }

    public function getAllData() {
        // $subquery = LogSensor::select(
        //     'id_log_sensor',
        //     DB::raw("CONCAT(CAST(FLOOR(TIMESTAMPDIFF(SECOND, MIN(created_date), MAX(created_date)) / 60) AS UNSIGNED), ' menit') AS time_range")
        // )
        // ->groupBy('id_log_sensor');

        // $state = LogSensor::joinSub($subquery, 'sub', function ($join) {
        //     $join->on('log_sensor.id_log_sensor', '=', 'sub.id_log_sensor');
        // })
        // ->join('meja', 'log_sensor.id_meja', '=', 'meja.id_meja') // Add the join with the 'meja' table
        // ->select(
        //     'log_sensor.id_log_sensor',
        //     'meja.id_meja as meja_id', // Use an alias to disambiguate 'id_meja' from the 'meja' table
        //     DB::raw('GROUP_CONCAT(DISTINCT meja.nama_meja) as meja_values'), // Concatenate 'value' from the 'meja' table
        //     DB::raw('GROUP_CONCAT(log_sensor.value) as log_values'), // Concatenate 'value' from the 'log_sensor' table
        //     DB::raw('GROUP_CONCAT(log_sensor.created_date) as created_dates'), // Concatenate 'created_date' from the 'log_sensor' table
        //     'time_range'
        // )
        // ->groupBy('log_sensor.id_log_sensor', 'meja_id', 'time_range') // Group by both id_log_sensor and meja_id
        // ->orderBy('log_sensor.id_log_sensor')
        // ->get();

        $state = LogSensor::with('meja')->orderBy('id', 'desc')->get();

        foreach ($state as $key => $value) {
            if($value['duration'] > 60) {
                $value['duration'] = round($value['duration'] / 60, 1);
                $value['duration'] = strval($value['duration']) . ' Menit';
            } else {
                $value['duration'] = strval($value['duration']) . ' Detik';
            }
        }

        return datatables()
            ->of($state)
            ->make(true);

    }

    public function logHapus() {
        return view('laporan.hapus');
    }

    public function logHapusData() {
        $state = LogHapus::with('pesanan', 'menu')->orderBy('id', 'desc')->get();

        return datatables()
            ->of($state)
            ->make(true);
    }

    public function orderCustom() {
        return view('laporan.custom');
    }

    public function orderCustomData() {
        // cari paket biliard yang tipenya custom
        $paket = PaketBiliard::where('type', '=', 'custom')->get();
        $id_paket = [];
        $id_order = [];

        foreach ($paket as $value) {
            array_push($id_paket, $value['id_paket_biliard']);
        }

        $state = OrderBiliardDetail::whereIn('id_paket_biliard', $id_paket)->with('order', 'paket')->orderBy('id_order_biliard', 'desc')->get();
        foreach ($state as $item) {
            $id_meja_biliard = $item->order->id_meja_biliard;
            // dd($id_meja_biliard);
            // Retrieve "meja" data using the ID
            $meja = MejaBiliard::where('id_meja_biliard', '=', $id_meja_biliard)->get()[0];

            // Add $meja as a new property to the $item
            $item->meja = $meja;
        }

        return datatables()
            ->of($state)
            ->make(true);
    }
}

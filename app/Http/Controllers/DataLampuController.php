<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MejaBiliard;
use App\Models\LogSensor;
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
        $state = MejaBiliard::where('id_meja_biliard', '=', $request->id_meja)->first();
        $uuid = Str::uuid()->toString();

        if($state->status != "Dipakai") {
            // jika meja tidak sedang dipakai tapi lampu nyala, insert log
            $meja = new LogSensor();
            $request->duration = 0;


            $data = [
                'id_meja' => $request->id_meja,
                'duration' => $request->duration,
                'value' => $request->value,
                'created_date' => $request->created_date,
                'id_log_sensor' => $request->id_log_sensor
            ];

            if(!$request->id_log_sensor) {
                $data['id_log_sensor'] = $uuid;
            }

            $meja = LogSensor::create($data);

            return response()->json(['code' => 200, 'message'=> 'Data berhasil disimpan', 'data' => $data], 200);
        }
        return ($state);
    }

    public function getAll() {
        $state = LogSensor::with('meja')->orderBy('id')->get();
        return view('laporan.sensor', compact('state'));
        
    }

    public function getAllData() {
        $subquery = LogSensor::select(
            'id_log_sensor',
            DB::raw("CONCAT(CAST(FLOOR(TIMESTAMPDIFF(SECOND, MIN(created_date), MAX(created_date)) / 60) AS UNSIGNED), ' menit') AS time_range")
        )
        ->groupBy('id_log_sensor');
    
        $state = LogSensor::joinSub($subquery, 'sub', function ($join) {
            $join->on('log_sensor.id_log_sensor', '=', 'sub.id_log_sensor');
        })
        ->join('meja', 'log_sensor.id_meja', '=', 'meja.id_meja') // Add the join with the 'meja' table
        ->select(
            'log_sensor.id_log_sensor',
            'meja.id_meja as meja_id', // Use an alias to disambiguate 'id_meja' from the 'meja' table
            DB::raw('GROUP_CONCAT(DISTINCT meja.nama_meja) as meja_values'), // Concatenate 'value' from the 'meja' table
            DB::raw('GROUP_CONCAT(log_sensor.value) as log_values'), // Concatenate 'value' from the 'log_sensor' table
            DB::raw('GROUP_CONCAT(log_sensor.created_date) as created_dates'), // Concatenate 'created_date' from the 'log_sensor' table
            'time_range'
        )
        ->groupBy('log_sensor.id_log_sensor', 'meja_id', 'time_range') // Group by both id_log_sensor and meja_id
        ->orderBy('log_sensor.id_log_sensor')
        ->get();
    

        return datatables()
            ->of($state)
            ->make(true);
        
    }
}

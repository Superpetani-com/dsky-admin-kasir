<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MejaBiliard;
use App\Models\LogSensor;

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
        if($state->status != "Dipakai") {
            // jika meja tidak sedang dipakai tapi lampu nyala, insert log
            $meja = new LogSensor();
            $meja = LogSensor::create($request->all());

            return response()->json(['code' => 200, 'message'=> 'Data berhasil disimpan', 'data' => $request->all()], 200);
        }
        return ($state);
    }
}

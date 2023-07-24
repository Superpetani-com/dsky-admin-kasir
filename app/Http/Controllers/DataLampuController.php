<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MejaBiliard;

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
}

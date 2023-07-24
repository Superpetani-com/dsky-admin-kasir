<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use PDF;

class LaporanTestController extends Controller
{
    public function indextest(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
        $tanggalAkhir = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+1, date('Y')));

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir!= "") {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporantest.index', compact('tanggalAwal', 'tanggalAkhir'));
    }
    
    public function getDatatest($awal, $akhir)
    {
        $no = 1;
        $data = array();
        $pendapatan = 0;
        $total_pendapatan = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
            $total_cafe = Pesanan::where('created_at', 'LIKE', "%$tanggal%")->sum('TotalBayar');
            
            $total_pendapatan += $total_cafe;

            if (Pesanan::where('created_at', 'LIKE', "%$tanggal%")->exists()){
            $order = Pesanan::with('meja')
            ->where('created_at', 'LIKE', "%$tanggal%")
            ->Get();
            foreach ($order as $item) {
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['tanggal']     = tanggal_indonesia($tanggal, false);
                $row['No.Order']    = $item->Id_pesanan;
                $row['No.Meja']     = $item->meja['nama_meja'];
                $row['Customer']    = $item->customer;
                $row['TotalItem']    = $item->TotalItem.' Item';
                $row['TotalBayar']  = 'Rp.'.format_uang($item->TotalBayar);
                $data[] = $row;
                }
            }
            else {
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['tanggal']     = tanggal_indonesia($tanggal, false);
                $row['No.Order']    = '-';
                $row['No.Meja']     = '-';
                $row['Customer']    = '-';
                $row['TotalItem']    = '-';
                $row['TotalBayar']  = '-';
                $data[] = $row;
            }           
             
        }

        $data[] = [
            'DT_RowIndex' => ' ',
            'tanggal' => ' ',
            'No.Order' => ' ',
            'No.Meja' => ' ',
            'Customer' => ' ',
            'TotalItem' => 'TotalPendapatan ',
            'TotalBayar' => 'Rp.'.format_uang($total_pendapatan),
        ];

        return $data;
    }

    public function datatest($awal, $akhir)
    {
        $data = $this->getDatacafe($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }
    public function exportPDFtest($awal, $akhir)
    {
        $data = $this->getDatatest($awal, $akhir);
        $pdf  = PDF::loadView('LaporanTest.pdf', compact('awal', 'akhir', 'data'));
        $pdf->setPaper('a4', 'potrait');
        
        return $pdf->stream('Laporan-pendapatan-cafe-'. date('Y-m-d-his') .'.pdf');
    }

    public function cetaktest($awal, $akhir)
    {
        $data = $this->getDataTest($awal, $akhir);
        //return ($data[0]['DT_RowIndex']);
        return view('laporantest.cetak', compact('data', 'awal', 'akhir'));
    }
}

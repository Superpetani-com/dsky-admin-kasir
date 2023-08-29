<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\OrderBiliard;
use PDF;

class LaporanCafeController extends Controller
{
    public function indexcafe(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
        $tanggalAkhir = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+1, date('Y')));

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir!= "") {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporancafe.index', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function getDatacafe($awal, $akhir)
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
                $order = Pesanan::with('meja')->where('created_at', 'LIKE', "%$tanggal%")->where('TotalBayar', '>', 0)->Get();
                foreach ($order as $item) {
                    $row = array();
                    $row['DT_RowIndex'] = $no++;
                    $row['tanggal']     = date($item->created_at);
                    $row['No.Order']    = $item->Id_pesanan;
                    $row['No.Meja']     = $item->meja['nama_meja'];
                    $row['Customer']    = $item->customer;
                    $row['TotalItem']    = $item->TotalItem.' Item';
                    $row['TotalBayar']  = 'Rp.'.format_uang($item->TotalBayar);

                    $item->isOrder = false;
                    $order = OrderBiliard::where('id_pesanan', '=', $item->Id_pesanan)->get();
                    // dd($item);
                    if(count($order) > 0) {
                        $item->isOrder = true;
                        $row['No.Meja'] = 'Meja Biliard '.$item->meja['id_meja'];
                    }
                    $data[] = $row;
                }

                // dd($data);;
            } else {
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

    public function datacafe($awal, $akhir)
    {
        $data = $this->getDatacafe($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }
    public function exportPDFcafe($awal, $akhir)
    {
        $data = $this->getDatacafe($awal, $akhir);
        $pdf  = PDF::loadView('LaporanCafe.pdf', compact('awal', 'akhir', 'data'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream('Laporan-pendapatan-cafe-'. date('Y-m-d-his') .'.pdf');
    }

    public function cetakcafe($awal, $akhir)
    {
        $data = $this->getDatacafe($awal, $akhir);
        //return ($data[0]['DT_RowIndex']);
        return view('laporancafe.cetak', compact('data', 'awal', 'akhir'));
    }
}

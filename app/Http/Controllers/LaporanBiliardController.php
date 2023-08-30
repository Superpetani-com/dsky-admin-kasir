<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderBiliard;
use PDF;
use DateTime;

class LaporanBiliardController extends Controller
{
    public function indexbiliard(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
        $tanggalAkhir = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+1, date('Y')));

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir!= "") {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporanbiliard.index', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function getDatabiliard($awal, $akhir)
    {
        $no = 1;
        $data = array();
        $pendapatan = 0;
        $total_pendapatan = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $awalDate = new DateTime($awal);

            // Move to the next day
            $awalDate->modify('+1 day');

            $total_biliard = OrderBiliard::whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 04:00:00')])->sum('totalbayar');

            $total_pendapatan += $total_biliard;

            if (OrderBiliard::whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 04:00:00')])->exists()){
            $order = OrderBiliard::with('meja')
            ->whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 04:00:00')])
            ->where('TotalBayar', '>', 0)
            ->get();
            foreach ($order as $item) {
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['tanggal']     = date($item->created_at);
                $row['No.Order']    = $item->id_order_biliard;
                $row['No.Meja']     = $item->meja['namameja'];
                $row['Customer']    = $item->customer;
                $row['TotalJam']    = $item->totaljam.'Jam';
                $row['TotalBayar']  = 'Rp.'.format_uang($item->totalbayar);
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
                $row['TotalJam']    = '-';
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
            'TotalJam' => 'TotalPendapatan ',
            'TotalBayar' => 'Rp.'.format_uang($total_pendapatan),
        ];

        return $data;
    }

    public function databiliard($awal, $akhir)
    {
        $data = $this->getDatabiliard($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }
    public function exportPDFbiliard($awal, $akhir)
    {
        $data = $this->getDatabiliard($awal, $akhir);
        $pdf  = PDF::loadView('LaporanBiliard.pdf', compact('awal', 'akhir', 'data'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream('Laporan-pendapatan-biliard-'. date('Y-m-d-his') .'.pdf');
    }

    public function cetakbiliard($awal, $akhir)
    {
        $data = $this->getDatabiliard($awal, $akhir);
        //return ($data[0]['DT_RowIndex']);
        return view('laporanbiliard.cetak', compact('data', 'awal', 'akhir'));
    }
}

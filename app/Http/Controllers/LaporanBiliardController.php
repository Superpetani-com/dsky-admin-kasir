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
        $tanggalAwal = date('Y-m-d H:i', strtotime('00:00'));
        $tanggalAkhir = date('Y-m-d H:i', strtotime('23:59:59'));

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir!= "") {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporanbiliard.index', compact('tanggalAwal', 'tanggalAkhir'));
    }

    function hasTimeComponent($dateString) {
        // Parse the date string
        $date = date_parse($dateString);

        // Check if any time-related components are present (hours, minutes, seconds)
        return ($date['hour'] !== false || $date['minute'] !== false || $date['second'] !== false);
    }

    public function getDatabiliard($awal, $akhir)
    {
        $no = 1;
        $data = [];
        $total_pendapatan = 0;
        $uniqueOrderIds = [];

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $dateAwal = new DateTime($awal);
            $startTime = $dateAwal->format('H:i');

            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
            $akhirDate = new DateTime($akhir);
            $endTime = $akhirDate->format('H:i');

            if(!$this->hasTimeComponent($akhir)) {
                $akhir = $akhir . " 23:59";
            }

            if(!$this->hasTimeComponent($awal)) {
                $awal = $awal . " 00:00";
            }

            // dd($awal, $akhir);

            // $total_biliard = OrderBiliard::whereBetween('created_at', [$dateAwal->format('Y-m-d ' . $startTime), $akhirDate->format('Y-m-d ' . $endTime)])->sum('totalbayar');
            // $total_pendapatan += $total_biliard;

            if (OrderBiliard::whereBetween('created_at', [$dateAwal->format('Y-m-d ' . $startTime), $akhirDate->format('Y-m-d ' . $endTime)])->exists()) {
                $order = OrderBiliard::with('meja')
                    ->whereBetween('created_at', [$dateAwal->format('Y-m-d ' . $startTime), $akhirDate->format('Y-m-d ' . $endTime)])
                    ->where('TotalBayar', '>', 0)
                    ->orderBy('id_order_biliard', 'desc')
                    ->get();
                // dd($order);
                foreach ($order as $item) {
                    if (!in_array($item->id_order_biliard, $uniqueOrderIds)) {
                        $uniqueOrderIds[] = $item->id_order_biliard; // Mark 'No.Order' as seen
                        $total_pendapatan += $item->totalbayar;
                        $data[] = [
                            'DT_RowIndex' => $no++,
                            'tanggal' => date($item->created_at),
                            'No.Order' => $item->id_order_biliard,
                            'No.Meja' => $item->meja['namameja'],
                            'Customer' => $item->customer,
                            'TotalJam' => $item->totaljam . ' Jam',
                            'TotalBayar' => 'Rp.' . format_uang($item->totalbayar),
                            'created_by' => $item->created_by,
                            'waiter_name' => $item->waiter_name
                        ];
                    }

                }
            } else {
                $data[] = [
                    'DT_RowIndex' => $no++,
                    'tanggal' => tanggal_indonesia($tanggal, false),
                    'No.Order' => '-',
                    'No.Meja' => '-',
                    'Customer' => '-',
                    'TotalJam' => '-',
                    'TotalBayar' => '-',
                    'created_by' => '-',
                ];
            }
        }

        $data[] = [
            'DT_RowIndex' => ' ',
            'tanggal' => ' ',
            'No.Order' => ' ',
            'No.Meja' => ' ',
            'Customer' => ' ',
            'TotalJam' => 'Total Pendapatan ',
            'TotalBayar' => 'Rp.' . format_uang($total_pendapatan),
            'created_by' => '',
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
        $pdf = PDF::loadView('laporanbiliard', [
            'awal' => $awal,
            'akhir' => $akhir,
            'data' => $data
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-pendapatan-biliard-'. date('Y-m-d-his') .'.pdf');
    }

    public function cetakbiliard($awal, $akhir)
    {
        $data = $this->getDatabiliard($awal, $akhir);
        //return ($data[0]['DT_RowIndex']);
        return view('laporanbiliard.cetak', compact('data', 'awal', 'akhir'));
    }
}

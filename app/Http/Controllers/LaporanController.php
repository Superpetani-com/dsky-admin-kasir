<?php

namespace App\Http\Controllers;
use App\Models\OrderBiliard;
use App\Models\Pesanan;
use PDF;
use DateTime;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporan.index', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function getData($awal, $akhir)
    {
        $no = 1;
        $data = array();
        $total_pendapatan = 0;
        $total_biliards = 0;
        $total_cafes = 0;

        // Convert string dates to DateTime objects
        $awalDate = new DateTime($awal);
        $akhirDate = new DateTime($akhir);

        // Initialize $awal and $akhir to start and end of the specified dates
        $awal = $awalDate->format('Y-m-d 12:00:00');
        $akhir = $akhirDate->format('Y-m-d 04:00:00');

        // dd($awal, $akhir);

        while ($awalDate <= $akhirDate) {
            $tanggal = $awalDate->format('Y-m-d');
            $tanggalSelanjutnya = $awalDate->format('Y-m-d');

            // Move to the next day
            $awalDate->modify('+1 day');

            // \DB::enableQueryLog();
            $total_biliard = OrderBiliard::whereBetween('created_at', ["$tanggal 12:00:00", $awalDate->format('Y-m-d 03:00:00')])->sum('totalbayar');
            $total_cafe = Pesanan::whereBetween('created_at', ["$tanggal 12:00:00", $awalDate->format('Y-m-d 03:00:00')])->sum('TotalBayar');
            // dd(\DB::getQueryLog());
            $pendapatan = $total_biliard + $total_cafe;
            $total_pendapatan += $pendapatan;
            $total_biliards += $total_biliard;
            $total_cafes += $total_cafe;

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['tanggal'] = tanggal_indonesia($tanggal, false);
            $row['total_biliard'] = format_uang($total_biliard);
            $row['total_cafe'] = format_uang($total_cafe);

            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => 'Total Pendapatan',
            'total_biliard' => format_uang($total_biliards),
            'total_cafe' => format_uang($total_cafes),
            'total_all' => format_uang($total_pendapatan),
        ];

        return $data;
    }

    // public function getData($awal, $akhir, $filterDate = null)
    // {
    //     // $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
    //     // dd($awal);
    //     $targetTime = '03:00:00'; // Target time until 03:00 AM

    //     $order_billiard = DB::table('order_biliard')
    //     ->select(
    //         DB::raw("DATE_SUB(CASE WHEN created_at >= CONCAT(CURDATE(), ' $targetTime') THEN DATE(created_at) ELSE DATE_SUB(DATE(created_at), INTERVAL 0 DAY) END, INTERVAL 0 DAY) AS order_date"),
    //         DB::raw('SUM(totalbayar) AS total_sum')
    //     )
    //     ->groupBy('order_date');

    //     // Get the query result as an array
    //     $queryResult = $order_billiard->get()->toArray();
    //     // dd($queryResult);
    //     $pesanan = DB::table('pesanan')
    //     ->select(
    //         DB::raw("DATE_SUB(CASE WHEN created_at >= CONCAT(CURDATE(), ' $targetTime') THEN DATE(created_at) ELSE DATE_SUB(DATE(created_at), INTERVAL 0 DAY) END, INTERVAL 0 DAY) AS order_date"),
    //         DB::raw('SUM(TotalBayar) AS total_sum')
    //     )
    //     ->groupBy('order_date');

    //     $pesananResult = $pesanan->get()->toArray();

    //     $queryCount = count($queryResult);
    //     $pesananCount = count($pesananResult);
    //     $maxCount = max($queryCount, $pesananCount);

    //     for ($i = 0; $i < $maxCount; $i++) {
    //         // Check if the current index is within bounds for both arrays
    //         $queryDate = ($i < $queryCount) ? $queryResult[$i]->order_date : null;
    //         $pesananDate = ($i < $pesananCount) ? $pesananResult[$i]->order_date : null;

    //         if ($queryDate === $pesananDate) {
    //             $queryResult[$i]->total_sum_cafe = $pesananResult[$i]->total_sum;
    //         } else {
    //             $queryResult[$i]->total_sum_cafe = 0;
    //         }
    //     }

    //     $filteredArray = Arr::where($queryResult, function ($value, $key) use ($awal, $akhir) {
    //         $orderDate = $value->order_date;
    //         return $orderDate >= $awal && $orderDate <= $akhir;
    //     });

    //     $totalSum = 0;
    //     $totalPesanan = 0;
    //     foreach ($filteredArray as $record) {
    //         $totalSum += $record->total_sum;
    //         $totalPesanan += $record->total_sum_cafe;
    //     }


    //     $response = [];
    //     $index = 1;
    //     foreach ($filteredArray as $record) {
    //         $response[] = [
    //             "DT_RowIndex" => $index,
    //             "tanggal" => $record->order_date,
    //             "total_biliard" => format_uang($record->total_sum),
    //             "total_cafe" => format_uang($record->total_sum_cafe),
    //         ];
    //         $index++;
    //     }

    //     $response[] = [
    //         'DT_RowIndex' => '',
    //         'tanggal' => 'Sub Total',
    //         'total_biliard' => format_uang($totalSum),
    //         'total_cafe' => format_uang($totalPesanan),
    //     ];

    //     $response[] = [
    //         'DT_RowIndex' => '',
    //         'tanggal' => '',
    //         'total_biliard' => 'Total Pendapatan',
    //         'total_cafe' => format_uang($totalSum + $totalPesanan),
    //     ];

    //     return $response;
    // }

    public function data($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function exportPDF($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);
        $pdf  = PDF::loadView('Laporan.pdf', compact('awal', 'akhir', 'data'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream('Laporan-pendapatan-'. date('Y-m-d-his') .'.pdf');
    }

}

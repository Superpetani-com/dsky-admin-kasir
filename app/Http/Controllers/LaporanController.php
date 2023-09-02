<?php

namespace App\Http\Controllers;
use App\Models\OrderBiliard;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Menu;
use PDF;
use DateTime;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Exports\UsersExport;
use App\Exports\CafeExport;
use App\Exports\OrderBiliardExport;
use App\Exports\BarangExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $awal = $awalDate->format('Y-m-d 09:00:00');
        $akhir = $akhirDate->format('Y-m-d 04:00:00');

        // dd($awal, $akhir);

        while ($awalDate <= $akhirDate) {
            $tanggal = $awalDate->format('Y-m-d');
            $tanggalSelanjutnya = $awalDate->format('Y-m-d');

            // Move to the next day
            $awalDate->modify('+1 day');

            // \DB::enableQueryLog();
            $total_biliard = OrderBiliard::whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])->sum('totalbayar');
            $total_cafe = Pesanan::whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])->sum('TotalBayar');
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

    public function data($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function exportPDF($awal, $akhir)
    {
        $data = $this->getTransferData($awal, $akhir);

        foreach ($data as &$subarray) {
            $totalBiliard = intval(str_replace('.', '', $subarray['total_biliard']));
            $totalCafe = intval(str_replace('.', '', $subarray['total_cafe']));
            $totalAll = $totalBiliard + $totalCafe;
            $subarray['total_all'] = number_format($totalAll, 0, ',', '.');;
        }

        $pdf = PDF::loadView('laporan', [
            'awal' => $awal,
            'akhir' => $akhir,
            'data' => $data
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-pendapatan-'. date('Y-m-d-his') .'.pdf');
    }

    public function exportExcel($awal, $akhir)
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new UsersExport($awal, $akhir), 'laporan_pendapatan_'.$awal.$akhir.'.xlsx');
    }

    public function indexTransfer(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporan.transfer', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function indexBarang(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporan.barang', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function getTransferData($awal, $akhir)
    {
        $no = 1;
        $data = array();
        $total_pendapatan = 0;
        $total_biliards = 0;
        $total_cafes = 0;
        $total_biliards_all = 0;
        $total_cafes_all = 0;

        $total_biliards_all_cash = 0;
        $total_biliards_all_tf = 0;

        $total_cafes_all_cash = 0;
        $total_cafes_all_tf = 0;

        // Convert string dates to DateTime objects
        $awalDate = new DateTime($awal);
        $akhirDate = new DateTime($akhir);

        // Initialize $awal and $akhir to start and end of the specified dates
        $awal = $awalDate->format('Y-m-d 09:00:00');
        $akhir = $akhirDate->format('Y-m-d 04:00:00');

        // dd($awal, $akhir);

        while ($awalDate <= $akhirDate) {
            $tanggal = $awalDate->format('Y-m-d');
            $tanggalSelanjutnya = $awalDate->format('Y-m-d');

            // Move to the next day
            $awalDate->modify('+1 day');

            // \DB::enableQueryLog();
            $total_biliard_cash = OrderBiliard::where('customer',  'not like', '%tf%')->whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])->sum('totalbayar');
            $total_biliard_tf = OrderBiliard::where('customer',  'like', '%tf%')->whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])->sum('totalbayar');

            $total_cafe_cash = Pesanan::where('customer',  'not like', '%tf%')->whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])->sum('TotalBayar');
            $total_cafe_tf = Pesanan::where('customer',  'like', '%tf%')->whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])->sum('TotalBayar');

            // dd(\DB::getQueryLog());

            $total_biliards = $total_biliard_cash + $total_biliard_tf;
            $total_cafes = $total_cafe_cash + $total_cafe_tf;

            $pendapatan = $total_biliards + $total_cafes;
            $total_pendapatan += $pendapatan;

            $total_biliards_all += $total_biliards;
            $total_cafes_all += $total_cafes;

            $total_biliards_all_cash += $total_biliard_cash;
            $total_biliards_all_tf += $total_biliard_tf;


            $total_cafes_all_cash += $total_cafe_cash;
            $total_cafes_all_tf += $total_cafe_tf;

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['tanggal'] = tanggal_indonesia($tanggal, false);
            $row['total_biliard_cash'] = format_uang($total_biliard_cash);
            $row['total_biliard_tf'] = format_uang($total_biliard_tf);
            $row['total_biliard'] = format_uang($total_biliards);
            $row['total_cafe_cash'] = format_uang($total_cafe_cash);
            $row['total_cafe_tf'] = format_uang($total_cafe_tf);
            $row['total_cafe'] = format_uang($total_cafes);

            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => 'Total Pendapatan',
            'total_biliard_cash' => format_uang($total_biliards_all_cash),
            'total_biliard_tf' => format_uang($total_biliards_all_tf),
            'total_biliard' => format_uang($total_biliards_all),
            'total_cafe_cash' => format_uang($total_cafes_all_cash),
            'total_cafe_tf' => format_uang($total_cafes_all_tf),
            'total_cafe' => format_uang(ceil($total_cafes_all / 1000) * 1000),
            'total_all' => format_uang(ceil($total_pendapatan / 1000) * 1000),
        ];

        return $data;
    }

    public function getBarangData($awal, $akhir)
    {
        $no = 1;
        $data = array();
        $total_pendapatan = 0;

        // Convert string dates to DateTime objects
        $awalDate = new DateTime($awal);
        $akhirDate = new DateTime($akhir);

        // Initialize $awal and $akhir to start and end of the specified dates
        $awal = $awalDate->format('Y-m-d 09:00:00');
        $akhir = $akhirDate->format('Y-m-d 04:00:00');

        // dd($awal, $akhir);

        while ($awalDate <= $akhirDate) {
            $tanggal = $awalDate->format('Y-m-d');
            $tanggalSelanjutnya = $awalDate->format('Y-m-d');

            // Move to the next day
            $awalDate->modify('+1 day');

            $pesanan = PesananDetail::select('id_menu', DB::raw('SUM(jumlah) as total_jumlah'))
                ->whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])
                ->groupBy('id_menu')
                ->orderBy('total_jumlah', 'desc')
                ->get();

            foreach ($pesanan as $item) {
                $row = array();
                $menu = Menu::where('Id_menu', '=', $item->id_menu)->first();

                $row['DT_RowIndex'] = $no++;
                $row['tanggal'] = tanggal_indonesia($tanggal, false);
                $row['nama_menu'] = $menu->Nama_menu;
                $row['kuantitas'] = $item->total_jumlah;
                $data[] = $row;
            }
        }

        return $data;
    }

    public function dataTransfer($awal, $akhir)
    {
        $data = $this->getTransferData($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function dataBarang($awal, $akhir)
    {
        $data = $this->getBarangData($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function exportExcelCafe($awal, $akhir)
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new CafeExport($awal, $akhir), 'laporan_cafe_'.$awal.$akhir.'.xlsx');
    }

    public function exportExcelBiliard($awal, $akhir)
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new OrderBiliardExport($awal, $akhir), 'laporan_biliard_'.$awal.$akhir.'.xlsx');
    }

    public function exportExcelBarang($awal, $akhir)
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new BarangExport($awal, $akhir), 'laporan_barang_'.$awal.$akhir.'.xlsx');
    }
}

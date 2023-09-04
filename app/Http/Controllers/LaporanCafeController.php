<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\OrderBiliard;
use App\Models\PesananDetail;
use PDF;
use DateTime;

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
        // dd($awal, $akhir);
        // Initialize variables
        $no = 1;
        $data = array();
        $total_pendapatan = 0;

        // Loop through date range
        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $dateAwal = new DateTime($awal);
            $startTime = $dateAwal->format('H:i');

            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
            $akhirDate = new DateTime($akhir);
            $endTime = $akhirDate->format('H:i');

            // Calculate total cafe sales for the day
            $total_cafe = Pesanan::whereBetween('created_at', [$dateAwal->format('Y-m-d ' . $startTime), $akhirDate->format('Y-m-d ' . $endTime)])->sum('TotalBayar');

            $total_pendapatan += $total_cafe;

            // Check if there are orders for the day
            if (Pesanan::whereBetween('created_at', [$dateAwal->format('Y-m-d ' . $startTime), $akhirDate->format('Y-m-d ' . $endTime)])->exists()) {
                $order = Pesanan::with('meja')
                    ->whereBetween('created_at', [$dateAwal->format('Y-m-d ' . $startTime), $akhirDate->format('Y-m-d ' . $endTime)])
                    ->where('TotalBayar', '>', 0)
                    ->orderBy('Id_pesanan', 'desc')
                    ->get();

                // Process and format orders
                foreach ($order as $item) {
                    $row = array();
                    $row['DT_RowIndex'] = $no++;
                    $row['tanggal']     = date($item->created_at);
                    $row['No.Order']    = $item->Id_pesanan;
                    $row['No.Meja']     = $item->meja['nama_meja'];
                    $row['Customer']    = $item->customer;
                    $row['TotalItem']   = $item->TotalItem . ' Item';
                    $row['TotalBayar']  = 'Rp.' . format_uang($item->TotalBayar);
                    $row['created_by']  = $item->created_by;
                    $nama_menu = [];

                    $detail = PesananDetail::where('id_pesanan', '=', $item->Id_pesanan)->with('menu')->get();

                    foreach ($detail as $value) {
                        if ($value->menu) {
                            array_push($nama_menu, $value->menu->Nama_menu . ' (' . $value->jumlah . ')');
                        }
                    }

                    $row['menus'] = implode(', ', $nama_menu);

                    $item->isOrder = false;
                    $order = OrderBiliard::where('id_pesanan', '=', $item->Id_pesanan)->get();

                    if (count($order) > 0) {
                        $item->isOrder = true;
                        $row['No.Meja'] = 'Meja Biliard ' . $item->meja['id_meja'];
                    }

                    $data[] = $row;
                }
            } else {
                // No orders for the day
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['tanggal']     = tanggal_indonesia($tanggal, false);
                $row['No.Order']    = '-';
                $row['No.Meja']     = '-';
                $row['Customer']    = '-';
                $row['TotalItem']   = '-';
                $row['TotalBayar']  = '-';
                $row['menus']       = '-';
                $row['created_by']  = '-';
                $data[] = $row;
            }
        }

        // Add total pendapatan row
        $data[] = [
            'DT_RowIndex' => ' ',
            'tanggal' => ' ',
            'No.Order' => ' ',
            'No.Meja' => ' ',
            'Customer' => ' ',
            'TotalItem' => ' ',
            'TotalBayar' => ' ',
            'menus' => 'Total Pendapatan ',
            'created_by' => 'Rp.' . format_uang($total_pendapatan),
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

        foreach ($data as &$item) {
            if (isset($item['menus']) && is_array($item['menus'])) {
                $item['menus'] = implode(', ', $item['menus']);
            }
        }

        $pdf = PDF::loadView('laporankafe', [
            'awal' => $awal,
            'akhir' => $akhir,
            'data' => $data
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-pendapatan-cafe-'. date('Y-m-d-his') .'.pdf');
    }

    public function cetakcafe($awal, $akhir)
    {
        $data = $this->getDatacafe($awal, $akhir);
        //return ($data[0]['DT_RowIndex']);
        return view('laporancafe.cetak', compact('data', 'awal', 'akhir'));
    }
}

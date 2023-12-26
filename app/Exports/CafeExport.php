<?php

namespace App\Exports;

use App\Models\Pesanan;
use App\Models\OrderBiliard;
use App\Models\PesananDetail;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CafeExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    protected $awal;
    protected $akhir;

    function __construct($awal, $akhir) {
        $this->awal = $awal;
        $this->akhir = $akhir;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Initialize variables
        $no = 1;
        $data = array();
        $total_pendapatan = 0;
        $uniqueOrderIds = [];

        // Loop through date range
        while (strtotime($this->awal) <= strtotime($this->akhir)) {
            $tanggal = $this->awal;
            $dateAwal = new DateTime($this->awal);
            $startTime = $dateAwal->format('H:i');

            $awal = date('Y-m-d', strtotime("+1 day", strtotime($this->awal)));
            $akhirDate = new DateTime($this->akhir);
            $endTime = $akhirDate->format('H:i');

            // Check if there are orders for the day
            if (Pesanan::whereBetween('created_at', [$dateAwal->format('Y-m-d ' . $startTime), $akhirDate->format('Y-m-d ' . $endTime)])->exists()) {
                $order = Pesanan::with('meja')
                    ->whereBetween('created_at', [$dateAwal->format('Y-m-d ' . $startTime), $akhirDate->format('Y-m-d ' . $endTime)])
                    ->where('TotalBayar', '>', 0)
                    ->orderBy('Id_pesanan', 'desc')
                    ->get();

                // Process and format orders
                foreach ($order as $item) {
                    if (!in_array($item->Id_pesanan, $uniqueOrderIds)) {
                        $uniqueOrderIds[] = $item->Id_pesanan; // Mark 'No.Order' as seen
                        $total_pendapatan += $item->TotalBayar;

                        $row = array();
                        $row['DT_RowIndex'] = $no++;
                        $row['tanggal']     = date($item->created_at);
                        $row['No.Order']    = $item->Id_pesanan;
                        $row['No.Meja']     = $item->meja['nama_meja'];
                        $row['Customer']    = $item->customer;
                        $row['TotalItem']   = $item->TotalItem . ' Item';
                        $row['TotalBayar']  = 'Rp.' . format_uang($item->TotalBayar);
                        $row['created_by']  = $item->created_by;
                        $row['waiter_name']  = $item->waiter_name;
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
                'waiter_name' => '',
                'menus' => 'Total Pendapatan ',
                'created_by' => 'Rp.' . format_uang($total_pendapatan),
            ];

            return collect($data);
        }
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "No.Order", "No.Meja", "Customer", "Jumlah Item", "Total Bayar", "Kasir", "Server", "Pesanan"];
    }
}

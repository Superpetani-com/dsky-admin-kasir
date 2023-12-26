<?php

namespace App\Exports;

use App\Models\OrderBiliard;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrderBiliardExport implements FromCollection, ShouldAutoSize, WithHeadings
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
        $no = 1;
        $data = array();
        $pendapatan = 0;
        $total_pendapatan = 0;
        $uniqueOrderIds = [];

        $awalDate = new DateTime($this->awal);
        $akhirDate = new DateTime($this->akhir);

        while ($awalDate <= $akhirDate) {
            $tanggal = $this->awal;
            $dateAwal = new DateTime($this->awal);
            $startTime = $dateAwal->format('H:i');

            $awal = date('Y-m-d', strtotime("+1 day", strtotime($this->awal)));
            $akhirDate = new DateTime($this->akhir);
            $endTime = $akhirDate->format('H:i');

            if (OrderBiliard::whereBetween('created_at', [$dateAwal->format('Y-m-d ' . $startTime), $akhirDate->format('Y-m-d ' . $endTime)])->exists()){
            $order = OrderBiliard::with('meja')
            ->whereBetween('created_at', [$dateAwal->format('Y-m-d ' . $startTime), $akhirDate->format('Y-m-d ' . $endTime)])
            ->where('TotalBayar', '>', 0)
            ->orderBy('id_order_biliard', 'desc')
            ->get();
            foreach ($order as $item) {
                    if (!in_array($item->id_order_biliard, $uniqueOrderIds)) {
                        $uniqueOrderIds[] = $item->id_order_biliard; // Mark 'No.Order' as seen
                        $total_pendapatan += $item->totalbayar;
                        $row = array();
                        $row['DT_RowIndex'] = $no++;
                        $row['tanggal']     = date($item->created_at);
                        $row['No.Order']    = $item->id_order_biliard;
                        $row['No.Meja']     = $item->meja['namameja'];
                        $row['Customer']    = $item->customer;
                        $row['TotalBayar']  = $item->totalbayar;
                        $row['created_by']    = $item->created_by;
                        $row['waiter_name']    = $item->waiter_name;
                        $data[] = $row;
                    }
                }
            }


            $data[] = [
                'DT_RowIndex' => ' ',
                'tanggal' => ' ',
                'No.Order' => ' ',
                'No.Meja' => ' ',
                'Customer' => 'Total Pendapatan ',
                'TotalBayar' => $total_pendapatan,
                'created_by' => '',
                'waiter_name' => '',
            ];

            return collect($data);
        }
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "No.Order", "No.Meja", "Customer", "Total Bayar", "Kasir", "Server"];
    }
}

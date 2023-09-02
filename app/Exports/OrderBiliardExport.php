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

        $awalDate = new DateTime($this->awal);
        $akhirDate = new DateTime($this->akhir);

        while ($awalDate <= $akhirDate) {
            $tanggal = $this->awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($this->awal)));

            $awalDate = new DateTime($awal);

            // Move to the next day
            // $awalDate->modify('+1 day');

            $total_biliard = OrderBiliard::whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])->sum('totalbayar');

            $total_pendapatan += $total_biliard;

            if (OrderBiliard::whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])->exists()){
            $order = OrderBiliard::with('meja')
            ->whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])
            ->where('TotalBayar', '>', 0)
            ->orderBy('id_order_biliard', 'desc')
            ->get();
            foreach ($order as $item) {
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['tanggal']     = date($item->created_at);
                $row['No.Order']    = $item->id_order_biliard;
                $row['No.Meja']     = $item->meja['namameja'];
                $row['Customer']    = $item->customer;
                $row['TotalBayar']  = $item->totalbayar;
                $row['created_by']    = $item->created_by;
                $data[] = $row;
                }
            }


            $data[] = [
                'DT_RowIndex' => ' ',
                'tanggal' => ' ',
                'No.Order' => ' ',
                'No.Meja' => ' ',
                'Customer' => ' ',
                'TotalJam' => 'Total Pendapatan ',
                'TotalBayar' => $total_pendapatan,
                'created_by' => '',
            ];

            return collect($data);
        }
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "No.Order", "No.Meja", "Customer", "Total Jam", "Total Bayar", "Kasir"];
    }
}

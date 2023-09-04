<?php

namespace App\Exports;

use App\Models\User;
use App\Models\OrderBiliard;
use App\Models\Pesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DateTime;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        $total_pendapatan = 0;
        $total_biliards = 0;
        $total_cafes = 0;
        $total_biliards_all = 0;
        $total_cafes_all = 0;

        $total_biliards_all_cash = 0;
        $total_biliards_all_tf = 0;

        $total_cafes_all_cash = 0;
        $total_cafes_all_tf = 0;

        // dd($this->awal, $this->akhir);

        while (strtotime($this->awal) <= strtotime($this->akhir)) {
            $tanggal = $this->awal;
            $dateAwal = new DateTime($this->awal);

            $this->awal = date('Y-m-d', strtotime("+1 day", strtotime($this->awal)));
            $akhirDate = new DateTime($this->akhir);

            $total_biliard = OrderBiliard::whereBetween('created_at', [$dateAwal, $akhirDate])->sum('totalbayar');
            $total_cafe = Pesanan::whereBetween('created_at', [$dateAwal, $akhirDate])->sum('TotalBayar');

            $total_biliard_cash = OrderBiliard::where('customer',  'not like', '%tf%')->whereBetween('created_at', [$dateAwal, $akhirDate])->sum('totalbayar');
            $total_biliard_tf = OrderBiliard::where('customer',  'like', '%tf%')->whereBetween('created_at', [$dateAwal, $akhirDate])->sum('totalbayar');

            $total_cafe_cash = Pesanan::where('customer',  'not like', '%tf%')->whereBetween('created_at', [$dateAwal, $akhirDate])->sum('TotalBayar');
            $total_cafe_tf = Pesanan::where('customer',  'like', '%tf%')->whereBetween('created_at', [$dateAwal, $akhirDate])->sum('TotalBayar');

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
            $row['total_biliard_cash'] = ($total_biliard_cash);
            $row['total_biliard_tf'] = ($total_biliard_tf);
            $row['total_biliard'] = ($total_biliards);
            $row['total_cafe_cash'] = ($total_cafe_cash);
            $row['total_cafe_tf'] = ($total_cafe_tf);
            $row['total_cafe'] = ($total_cafes);
            $row['total_all'] = ($total_biliards + $total_cafes);
            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => 'Total Pendapatan',
            'total_biliard_cash' => ($total_biliards_all_cash),
            'total_biliard_tf' => ($total_biliards_all_tf),
            'total_biliard' => ($total_biliards_all),
            'total_cafe_cash' => ($total_cafes_all_cash),
            'total_cafe_tf' => ($total_cafes_all_tf),
            'total_cafe' => (ceil($total_cafes_all / 1000) * 1000),
            'total_all' => (ceil($total_pendapatan / 1000) * 1000),
        ];

        // dd($data);

        return collect($data);
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "Penjualan Biliard (Cash)", "Penjualan Biliard (Tf)", "Penjualan Biliard", "Penjualan Cafe (Cash)", "Penjualan Cafe (Tf)", "Penjualan Cafe", "Total Penjualan"];
    }
}

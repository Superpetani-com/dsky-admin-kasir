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
        $no = 1;
        $data = array();
        $pendapatan = 0;
        $total_pendapatan = 0;
        // dd($awal, $akhir, 'askdna');

        $awalDate = new DateTime($this->awal);
        $akhirDate = new DateTime($this->akhir);

        while ($awalDate <= $akhirDate) {
            $tanggal = $this->awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($this->awal)));


            $awalDate = new DateTime($awal);
            // Move to the next day
            // $awalDate->modify('+1 day');

            $total_cafe = Pesanan::whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])->sum('TotalBayar');
            // dd($awalDate->format('Y-m-d 07:00:00'));
            $total_pendapatan += $total_cafe;
            // dd($total_cafe);

            if (Pesanan::whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])->exists()){
                $order = Pesanan::with('meja')->whereBetween('created_at', ["$tanggal 09:00:00", $awalDate->format('Y-m-d 07:00:00')])->where('TotalBayar', '>', 0)->orderBy('Id_pesanan', 'desc')->get();
                // dd($order);
                foreach ($order as $item) {
                    $row = array();
                    $row['DT_RowIndex'] = $no++;
                    $row['tanggal']     = date($item->created_at);
                    $row['No.Order']    = $item->Id_pesanan;
                    $row['No.Meja']     = $item->meja['nama_meja'];
                    $row['Customer']    = $item->customer;
                    $row['TotalItem']    = $item->TotalItem.' Item';
                    $row['TotalBayar']  = $item->TotalBayar;
                    $row['created_by']    = $item->created_by;
                    $nama_menu = [];

                    $detail = PesananDetail::where('id_pesanan', '=', $item->Id_pesanan)->with('menu')->get();

                    foreach ($detail as $value) {
                        array_push($nama_menu, $value->menu->Nama_menu);
                        // $nama_menu += $value->menu->Nama_menu;
                    }


                    $row['menus'] = $nama_menu;

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
            }

            // dd($data);;
            $data[] = [
                'DT_RowIndex' => ' ',
                'tanggal' => ' ',
                'No.Order' => ' ',
                'No.Meja' => ' ',
                'Customer' => ' ',
                'TotalItem' => 'Total Pendapatan',
                'TotalBayar' => $total_pendapatan,
                'menus' => '',
                'created_by' => '',
            ];


            return collect($data);
        }
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "No.Order", "No.Meja", "Customer", "Jumlah Item", "Total Bayar", "Kasir", "Pesanan"];
    }
}

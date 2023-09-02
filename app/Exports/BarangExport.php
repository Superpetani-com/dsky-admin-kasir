<?php

namespace App\Exports;

use App\Models\PesananDetail;
use App\Models\Menu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DateTime;
use Illuminate\Support\Facades\DB;


class BarangExport implements FromCollection, WithHeadings, ShouldAutoSize
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

        // Convert string dates to DateTime objects
        $awalDate = new DateTime($this->awal);
        $akhirDate = new DateTime($this->akhir);

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
                $row['kuantitas'] = $item->total_jumlah;

                if($menu) {
                    $row['nama_menu'] = $menu->Nama_menu;
                    $row['harga'] = ($menu->Harga);
                    $row['total'] = ($menu->Harga * $item->total_jumlah);
                    $total_pendapatan += $menu->Harga * $item->total_jumlah;
                }

                $data[] = $row;
            }
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'nama_menu' => '',
            'kuantitas' => '',
            'harga' => '',
            'total' => ($total_pendapatan)
        ];

        return collect($data);
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "Nama Menu", "Kuantitas"];
    }
}

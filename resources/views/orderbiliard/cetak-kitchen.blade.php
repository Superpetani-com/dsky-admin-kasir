<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Pembayaran</title>
    <?php
    $style = '
    <style>
        * {
            font-family: "consolas", sans-serif;
        }
        p {
            display: block;
            margin: 3px;
            font-size: 10pt;
        }
        table td {
            font-size: 9pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        @media print {
            @page {
                margin: 0;
                size: 75mm
    ';
    ?>
    <?php
    $style .=
        ! empty($_COOKIE['innerHeight'])
            ? $_COOKIE['innerHeight'] .'mm; }'
            : '}';
    ?>
    <?php
    $style .= '
            html, body {
                width: 70mm;
            }
            .btn-print {
                display: none;
            }
        }
    </style>
    ';
    ?>

    {!! $style !!}
</head>

<body onload="window.print()">
<button class="btn-print" style="position: absolute; right: 1rem; top: rem;" onclick="window.print()">Print</button>
    <div class="text-center">
        {{-- <h3 style="margin-bottom: 5px;">{{ strtoupper("NOTA BILIARD") }}</h3> --}}
    </div>
    <br>
    <div>
    <div>
        {{-- <p style="float: left;">{{ $order->created_at }}</p> --}}
        <p style="float: left">Kasir: {{ ucwords(auth()->user()->name) }}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>Cutomer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ ucwords($order->customer) }}</p>
    <p>No Order &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ ($order->id_order_biliard) }}-{{ $order->id_pesanan }}</p>
    <p>No Meja &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ ($nama_meja) }}</p>
    <p>Tanggal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ ($pesanan->created_at) }}</p>
    {{-- <p>Jam Mulai &nbsp;&nbsp;&nbsp;: {{ ($meja->jammulai) }}</p>
    <p>Jam Selesai : {{ ($meja->jamselesai) }}</p> --}}

    <p class="text-center">===================================</p>
    <br>

    <table width="100%" style="border: 0;">
        {{-- <tr>
            <td>Total Jam:</td>
            <td class="text-right">{{ ($order->totaljam) }} Jam</td>
        </tr> --}}
        {{-- <tr>
            <td>Total Harga:</td>
            <td class="text-right">Rp.{{ format_uang($order->totalharga) }}</td>
        </tr>
        <tr>
            <td>Diskon:</td>
            <td class="text-right">{{ format_uang($order->diskon) }}%</td>
        </tr> --}}
        {{-- <tr>
            <td>Total Bayar:</td>
            <td class="text-right">Rp.{{ format_uang($order->totalbayar) }}</td>
        </tr> --}}
        {{-- <tr>
            <td>Diterima:</td>
            <td class="text-right">Rp.{{ format_uang($order->diterima) }}</td>
        </tr>
        <tr>
            <td>Kembali:</td>
            <td class="text-right">Rp.{{ format_uang($order->kembali) }}</td>
        </tr> --}}
    </table>
    {{-- <p class="text-center">===================================</p> --}}
    {{-- <br> --}}
    <table width="100%" style="border:0;text-align: left;">
        <thead>
            <tr>
                <th>Nama Pesanan</th>
                <th>Kuantitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detailpesanan as $item)
            <tr>
                <td>{{ $item->menu->Nama_menu }}</td>
                <td>{{ $item->jumlah }} buah</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <p class="text-center">-----------------------------------</p> --}}
    <br>
    <p class="text-center">===================================</p>
    <table width="100%" style="border: 0;">
        {{-- <tr>
            <td>Total Item:</td>
            <td class="text-right">{{ format_uang($pesanan->TotalItem) }} Item</td>
        </tr> --}}
        {{-- <tr>
            <td>Total Harga:</td>
            <td class="text-right">Rp.{{ format_uang(ceil($pesanan->TotalHarga / 100) * 100) }}</td>
        </tr> --}}
        {{-- <tr>
            <td>Diskon:</td>
            <td class="text-right">{{ format_uang($pesanan->Diskon) }}%</td>
        </tr> --}}
        {{-- <tr>
            <td>Services:</td>
            <td class="text-right">Rp.{{ format_uang($pesanan->ppn) }}</td>
        </tr> --}}
        {{-- <tr>
            <td>Total:</td>
            <td class="text-right">Rp.{{ format_uang($order->totalharga + $pesanan->TotalBayar) }}</td>
        </tr> --}}
        {{-- <tr>
            <td>Diterima:</td>
            <td class="text-right">Rp.{{ format_uang($pesanan->Diterima) }}</td>
        </tr> --}}
        {{-- <tr>
            <td>Kembali:</td>
            <td class="text-right">Rp.{{ format_uang($pesanan->Kembali) }}</td>
        </tr> --}}
    </table>
    {{-- <p class="text-center">===================================</p>

    <p class="text-center">-- TERIMA KASIH --</p> --}}

    <script>
        window.onload = function() {
            if(!window.location.hash) {
                window.location = window.location + '#loaded';
                window.location.reload();
            }
            window.print()
        }
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
            body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight
        );
        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight="+ ((height + 40) * 0.264583);
    </script>
    </body>
</html>

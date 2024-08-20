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
                margin: 12px;
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
        <h3 style="margin-bottom: 5px;">{{ strtoupper("Jakal 9 Billiard") }}</h3>
        <p>{{ ucwords("Jln. Kaliurang KM 9.5") }}</p>
        <p>{{ ucwords("BCA : 0376-616-333 (Billiard Indonesia)") }}</p>
        <p>{{ ucwords("WA : 081225557100") }}</p>
        <p>{{ ucwords("IG : @jakal9.billiard") }}</p>
    </div>
    <br>
    <br>
    <div>
    {{-- <div>
        <p style="float: left;">{{ $pesanan->created_at }}</p>
        <p style="float: left">Kasir: {{ $pesanan->created_by }}</p>
        <p style="float: left">Server: {{ $pesanan->waiter_name }}</p>
    </div> --}}
    <div class="clear-both" style="clear: both;"></div>
    <p>Kasir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ ($pesanan->created_by) }}</p>
    <p>Server &nbsp;&nbsp;&nbsp;&nbsp; : {{ ($pesanan->waiter_name) }}</p>
    <p>Customer &nbsp;&nbsp; : {{ ($pesanan->customer) }}</p>
    <p>No Pesanan &nbsp;: {{ ($pesanan->Id_pesanan) }}</p>
    <p>No Meja &nbsp;&nbsp;&nbsp; : {{ ($nama_meja) }}</p>
    <p>Tanggal &nbsp;&nbsp;&nbsp; : {{ ($pesanan->created_at) }}</p>

    <p class="text-center">===================================</p>
    <br>
    <table width="100%" style="border: 0;">
        @foreach ($detail as $item)
            <tr>
                <td colspan="3">{{ $item->menu->Nama_menu }}</td>
            </tr>
            <tr>
                <td>{{ $item->jumlah }} x Rp. {{ format_uang(ceil($item->harga / 100) * 100) }}</td>
                <td></td>
                <td class="text-right">Rp. {{ format_uang($item->jumlah * ceil($item->harga / 100) * 100) }}</td>
            </tr>
        @endforeach
    </table>
    <br>

    {{-- <p class="text-center">-----------------------------------</p> --}}
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
            <td>Services:</td>
            <td class="text-right">Rp.{{ format_uang(($pesanan->ppn)) }}</td>
        </tr> --}}
        <tr>
            <td>Total Bayar:</td>
            <td class="text-right">Rp.{{ format_uang($pesanan->TotalBayar) }}</td>
        </tr>
        {{-- <tr>
            <td>Diterima:</td>
            <td class="text-right">Rp.{{ format_uang($pesanan->Diterima) }}</td>
        </tr> --}}
        {{-- <tr>
            <td>Kembali:</td>
            <td class="text-right">Rp.{{ format_uang($pesanan->Kembali) }}</td>
        </tr> --}}
    </table>
    <p class="text-center">===================================</p>
    <p class="text-center">-- TERIMA KASIH --</p>

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

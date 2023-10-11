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
        <h3 style="margin-bottom: 5px;">{{ strtoupper("XT Billiard") }}</h3>
        <p>{{ ucwords("jl dr. sutomo cilacap") }}</p>
    </div>
    <br>
    <div>
    <div>
        <p style="float: left;">{{ date('d-m-Y') }}</p>
        <p style="float: right">Kasir:{{ ucwords(auth()->user()->name) }}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>Cutomer:{{ ucwords($order->customer) }}</p>
    <div class="clear-both" style="clear: both;"></div>
    <p>NoPesanan: {{ ($order->id_order_biliard) }}</p>
    <p class="text-center">===================================</p>
    <br>
    <table width="100%" style="border: 0;">
        @foreach ($detail as $item)
            <tr>
                <td colspan="3">{{ $item->paket->nama_paket }}</td>
            </tr>
            <tr>
                <td>{{ $item->jumlah }} Jam x Rp.{{ format_uang($item->harga) }}</td>
                <td></td>
                <td class="text-right">Rp.{{ format_uang($item->jumlah * $item->harga) }}</td>
            </tr>
        @endforeach
    </table>
    <p class="text-center">-----------------------------------</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td>Total Jam:</td>
            <td class="text-right">{{ ($order->totaljam) }} Jam</td>
        </tr>
        <tr>
            <td>Total Harga:</td>
            <td class="text-right">Rp.{{ format_uang($order->totalharga) }}</td>
        </tr>
        <tr>
            <td>Diskon:</td>
            <td class="text-right">{{ format_uang($order->diskon) }}%</td>
        </tr>
        <tr>
            <td>Total Bayar:</td>
            <td class="text-right">Rp.{{ format_uang($order->totalbayar) }}</td>
        </tr>
        <tr>
            <td>Diterima:</td>
            <td class="text-right">Rp.{{ format_uang($order->diterima) }}</td>
        </tr>
        <tr>
            <td>Kembali:</td>
            <td class="text-right">Rp.{{ format_uang($order->kembali) }}</td>
        </tr>
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

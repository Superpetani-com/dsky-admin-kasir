<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAPORAN PENDAPATAN CAFE</title>
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
        .tablepemasukan tbody tr:nth-last-child(1), .tablepemasukan tbody tr:nth-last-child(2) {
            display:none;
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
    <div class="text-center">
        <p>Laporan Pendapatan Cafe</p>
        <p>{{$awal}} s/d {{$akhir}}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>Tanggal Cetak: {{date('Y-m-d')}}</p>
    <p class="text-center">===================================</p>
    <br>
    <table width="100%" style="border: 0;" class="tablepemasukan">
            <tbody>
            @foreach ($data as $row)
                <tr>
                        <td>_____________</td>
                        <td>_____________</td>
                        <td>_____________</td>
                </tr>
                <tr>
                        <td>Order No:{{ $row['No.Order'] }}</td>
                        <td>{{ $row['tanggal'] }}</td>
                </tr>
                <tr>
                        <td>{{ $row['No.Meja'] }}</td>
                        <td>{{ $row['Customer'] }}</td>
                        <td>{{ $row['TotalBayar'] }}</td>
                </tr>

            @endforeach
            </tbody>
    </table>
    <p class="text-center">-----------------------------------</p>
    <p style="float: left">Total Pendapatan=</p>
    <p style="float: right">{{(last($data))['TotalBayar']}}</p>
    <table width="100%" style="border: 0;">

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

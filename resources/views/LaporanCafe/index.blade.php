@extends('HalamanAwal.master')

@section('title')
    Laporan Pendapatan Cafe {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
tr, .dataTables_length, .dataTables_filter, select.form-control.input-sm, input.form-control.input-sm{
    font-size: 12pt;
}
.btn-xs{font-size: 10pt;}
  tr:nth-child(even) {
  background-color: #cef0b1;
}
  thead{
  background-color: #96bf73;
  text-align: center;
}

.table tbody tr:last-child {
    background-color: #96bf73;
    }
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">LaporanCafe</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="updatePeriode()" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Ubah Periode</button>
                <a href="{{ route('laporan.export_pdfcafe', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
                <a href="{{ route('laporan.export_excelcafe', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank" class="btn btn-success btn-sm btn-flat"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                <button type="button" class="btn btn-primary btn-sm btn-flat btn-cetak"><i class="fa fa-book"></i> Cetak Laporan</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered" style="width:100%">
                    <thead>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th>No.Order</th>
                        <th>No.Meja</th>
                        <th>Customer</th>
                        <th>Jumlah Item</th>
                        <th>TotalBayar</th>
                        <th>Pesanan</th>
                        <th>Kasir</th>
                        <th>Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('LaporanCafe.form')
@endsection

@push('scripts')
<script src="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('laporan.datacafe', [$tanggalAwal, $tanggalAkhir]) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {
                    "mData": "No.Order",
                    "mRender": function (data, type, row) {
                        if(data > 0) {
                            return `<a href='{{ url('/pesanandetail/${data}') }}'>${data}</a>`;
                        }
                    }
                },
                {data: 'No.Meja'},
                {data: 'Customer'},
                {data: 'TotalItem'},
                {data: 'TotalBayar'},
                {data: 'menus'},
                {data: 'created_by'},
                {
                    "mData": "No.Order",
                    "mRender": function (data, type, row) {
                        if(data > 0) {
                            return `<button class="button-aksi bg-black" onclick="printNota(${data})">PRINT</button>`
                        }
                        // return `<a href='{{ url('/pesanandetail/${data}') }}'>${data}</a>`;
                    }
                },
            ],
            dom: 'Brt',
            bSort: false,
            bPaginate: false,
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        $('.btn-cetak').on('click', function () {
        cetak('{{ route('laporan.cetakcafe', [$tanggalAwal, $tanggalAkhir]) }}', 'Nota');
         });
    });

    $.fn.dataTable.ext.errMode = 'none';


    function updatePeriode() {
        $('#modal-form').modal('show');

    }

    function printNota(id) {
        var urlcetak=(`{{url('pesanan')}}/cetak/${id}`);
        cetak(urlcetak);
    }
    function cetak(url, title) {
    popupCenter(url, title, 625, 500);

    }

    function popupCenter(url, title, w, h) {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop  = window.screenTop  !==  undefined ? window.screenTop  : window.screenY;
        const width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        const systemZoom = width / window.screen.availWidth;
        const left       = (width - w) / 2 / systemZoom + dualScreenLeft
        const top        = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow  = window.open(url, title,
        `
            scrollbars=yes,
            width  = ${w / systemZoom},
            height = ${h / systemZoom},
            top    = ${top},
            left   = ${left}
        `
        );
        if (window.focus) newWindow.focus();
    }
</script>
@endpush

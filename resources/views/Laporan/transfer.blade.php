@extends('HalamanAwal.master')

@section('title')
    Laporan Pendapatan {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}
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
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Laporan Pendapatan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="updatePeriode()" class="btn btn-info btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Ubah Periode</button>
                {{-- <a href="{{ route('laporan.export_transferpdf', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-file-pdf-o"></i> Export PDF</a> --}}
                <a href="{{ route('laporan.export_excel', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank" class="btn btn-success btn-xs btn-flat"><i class="fa fa-file-excel-o"></i> Export Excel</a>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered" style="width:100%">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Penjualan Biliard (Cash)</th>
                        <th>Penjualan Biliard (Tf)</th>
                        <th>Penjualan Biliard</th>
                        <th>Penjualan Cafe (Cash)</th>
                        <th>Penjualan Cafe (Tf)</th>
                        <th>Penjualan Cafe</th>
                        <th>Total Penjualan</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('Laporan.form-transfer')
@endsection

@push('scripts')
<script src="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    let table;
    function formatIDR(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    }
    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('laporan.dataTransfer', [$tanggalAwal, $tanggalAkhir]) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'total_biliard_cash'},
                {data: 'total_biliard_tf'},
                {data: 'total_biliard'},
                {data: 'total_cafe_cash'},
                {data: 'total_cafe_tf'},
                {data: 'total_cafe'},
                {
                    data: null,
                    render: function (data, type, row) {
                        console.log(parseInt(data.total_biliard.split('.').join('')))
                        var total_biliard = parseInt(data.total_biliard.split('.').join('')); // Convert to numeric
                        var total_cafe = parseInt(data.total_cafe.split('.').join('')); // Convert to numeric
                        var total_all = total_biliard + total_cafe;

                        return formatIDR(total_all); // Format as currency
                    }
                }
            ],
            dom: 'Brt',
            bSort: false,
            bPaginate: false,
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });

    function updatePeriode() {
        $('#modal-form-transfer').modal('show');
    }
</script>
@endpush

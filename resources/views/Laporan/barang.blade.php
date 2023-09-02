@extends('HalamanAwal.master')

@section('title')
    Laporan Barang {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}
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
    <li class="active">Laporan Barang</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="updatePeriode()" class="btn btn-info btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Ubah Periode</button>
                <a href="{{ route('laporan.export_excelbarang', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-file-excel-o"></i> Export Excel</a>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered" style="width:100%">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Nama Menu</th>
                        <th>Kuantitas</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('Laporan.form-barang')
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
                url: '{{ route('laporan.dataBarang', [$tanggalAwal, $tanggalAkhir]) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'nama_menu'},
                {data: 'kuantitas'},
                {data: 'harga'},
                {data: 'total'},
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

    $.fn.dataTable.ext.errMode = 'none';

    function updatePeriode() {
        $('#modal-form-barang').modal('show');
    }
</script>
@endpush

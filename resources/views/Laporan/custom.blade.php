@extends('HalamanAwal.master')

@section('title')
   Log Order Custom
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
    <li class="active">Log Order Custom</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered" style="width:100%">
                    <thead>
                        <th width="5%">ID Order</th>
                        <th>ID Meja</th>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th>Kuantitas</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal Order</th>
                        <th>Nama Kasir</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('Laporan.form')
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
            autoWidth: true,
            ajax: {
                url: '{{ route('laporan.orderCustomData') }}',
            },
            columns: [
                {
                    "mData": "id_order_biliard",
                    "mRender": function (data, type, row) {
                        return `<a href='{{ url('/orderbiliarddetail/${data}/before') }}'>${data}</a>`;
                    }
                },
                // {data: 'id_pesanan', searchable: false, sortable: false},
                {data: 'meja.namameja'},
                {data: 'paket.nama_paket'},
                {data: 'harga'},
                {data: 'jumlah'},
                {data: 'order.totalharga'},
                {data: 'order.status'},
                {data: 'created_at'},
                {data: 'order.created_by'},
            ],
            bSort: false,
            bPaginate: true,
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });

    function updatePeriode() {
        $('#modal-form').modal('show');
    }
</script>
@endpush

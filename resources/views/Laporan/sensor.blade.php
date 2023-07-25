@extends('HalamanAwal.master')

@section('title')
   Log Sensor
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
    <li class="active">Sensor</li>
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
                        <th >ID</th>
                        <th>ID Meja</th>
                        <th>Nama Meja</th>
                        <th data-toggle="tooltip" data-placement="top" title="1 = Mati, 0 = Nyala">Kondisi Lampu</th>
                        <th>Durasi</th>
                        <th>Tanggal</th>
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
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('laporan.sensorData') }}',
            },
            columns: [
                {data: 'id_log_sensor', searchable: false, sortable: false},
                {data: 'meja_id'},
                {data: 'meja_values'},
                {data: 'log_values'},
                {data: 'time_range'},
                {data: 'created_dates'},
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
        $('#modal-form').modal('show');
    }
</script>
@endpush
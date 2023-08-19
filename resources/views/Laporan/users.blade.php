@extends('HalamanAwal.master')

@section('title')
   Users Manajemen
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
    <li class="active">Users Manajemen</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{route('user.register')}}')" class="btn btn-success  btn-flat"><i class="fa fa-plus-circle">
                </i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered" style="width:100%">
                    <thead>
                        <th width="5%">ID User</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terakhir Login</th>
                        <th>Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('Laporan.user-form')
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
                url: '{{ route('laporan.usersData') }}',
            },
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'email'},
                {
                    "mData": "level",
                    "mRender": function (data, type, row) {
                        if(data == 1) {
                            return 'Kasir'
                        } else if(data == 2) {
                            return 'Admin'
                        } else if(data == 3) {
                            return 'Superadmin'
                        } else if (data === 4) {
                            return 'Manager'
                        } else if(data == 5) {
                            return 'Kitchen'
                        } else {
                            return 'Waiters'
                        }
                    }
                },
                {
                    "data": "updated_at",
                    "render": function (data) {
                        var date = new Date(data);
                        var month = date.getMonth() + 1;
                        return (date.getDate() < 9 ? '0' + date.getDate() : date.getDate()) + "/"  + (month.toString().length > 1 ? month : "0" + month) + "/" + date.getFullYear() + " Pukul " + (date.getHours() < 9 ? '0' + date.getHours(): date.getHours()) + ":" + date.getMinutes() + ' WIB';
                    }
                },
                {
                    data: 'id',
                    render: function(data) {
                        return `<div class="btn-group">
                            <button onclick="editForm('{{ url('/user/edit/${data}') }}')" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"> </i> Edit</button>
                            <button onclick="deleteData('{{ url('/user/delete/${data}') }}')" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"> </i> Hapus</button>
                        </div>`
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
    });

    function updatePeriode() {
        $('#modal-form').modal('show');
    }

    function addForm(url){
      if ({{auth()->user()->level}} == 3){
        $('#modal-form-user').modal('show');
        $('#modal-form-user .modal-title').text('Tambah User Baru');

        $('#modal-form-user form')[0].reset();
        $('#modal-form-user form').attr('action', url);
        $('#modal-form-user [name=_method]').val('post');
        $('#modal-form-user [name=nama_paket]').focus();
      }
    }
    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush

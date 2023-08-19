@extends('HalamanAwal.master')

@section('title')
    Daftar Menu
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Menu</li>
@endsection
@push('css')
<style>
  .btn-hapus, .btn-edit{
    font-size:12pt;
  }
  .table_menu tbody tr:nth-child(even) {
  background-color: #cef0b1;
    }
  .table_menu  thead{background-color: #96bf73;}
  table{font-size: 12pt;}
  input[type="text"]{font-size:12pt;}
  input[type="number"]{font-size:12pt;}
</style>
@endpush
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <button onclick="addForm('{{route('menu.store')}}')" class="btn btn-success  btn-flat"><i class="fa fa-plus-circle">
              </i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
            <table class="table table-stiped table-bordered table_menu">
              <thead>
                <th width="5%">No</th>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Stok Update?</th>
                <th width="15%"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody></tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
</div>

@includeIf('menu.form')

@endsection

@push('scripts')
<script>
  let table;

  $(function(){
   table= $('.table').DataTable({
     responsive:true,
     processing: true,
     serverSide: true,
     autoWidth:false,
     ajax: {
        url: '{{route('menu.data')}}',
     },
     columns:[
        {data:'DT_RowIndex', searchable:false, sortable:false},
        {data:'Nama_menu'},
        {data:'Harga'},
        {data:'stok'},
        {data:'jenis'},
        {data:'aksi', searchable:false, sortable:false},
     ]
   });

    $('#modal-form').validator().on('submit', function (e){
      if(!e.preventDefault()){
        $.ajax({
           url: $('#modal-form form').attr('action'),
           type: 'post',
           data: $('#modal-form form').serialize()
        })
        .done((response)=>{
          $('#modal-form').modal('hide');
          table.ajax.reload();
        })
        .fail((errors)=>{
          alert('Tidak dapat menyimpan data');
          return;
        })
      }
    })

  });

  function addForm(url){
    if ({{auth()->user()->level}}==2 || {{auth()->user()->level}}==3 || {{auth()->user()->level}}==4){
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Tambah Menu');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('post');
    $('#modal-form [name=nama_menu]').focus();
    }
  }

  function editForm(url){
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit Menu');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');
    $('#modal-form [name=nama_menu]').focus();

    $.get(url)
        .done((response)=>{
          $('#modal-form [name=nama_menu]').val(response.Nama_menu);
          $('#modal-form [name=harga]').val(response.Harga);
          $('#modal-form [name=stok]').val(response.stok);
          $('#modal-form [name=jenis]').val(response.jenis);
        })
        .fail((errors)=>{
          alert('Tidak dapat menampilkan data');
          return;
        })
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

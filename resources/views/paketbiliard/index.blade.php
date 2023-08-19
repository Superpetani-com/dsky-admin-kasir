@extends('HalamanAwal.master')
@push('css')
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
  }
</style>
@endpush

@section('title')
    Daftar Paket Biliard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">PaketBiliard</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <button onclick="addForm('{{route('paketbiliard.store')}}')" class="btn btn-success  btn-flat"><i class="fa fa-plus-circle">
              </i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
            <table class="table table-stiped table-bordered">
              <thead>
                <th width="5%">No</th>
                <th width="20%">Nama Paket</th>
                <th width="13%">Harga</th>
                <th width="15%">Durasi(Menit)</th>
                <th width="35%">Keterangan</th>
                <th width="35%">Tipe</th>
                <th width="12%"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody></tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
</div>

@includeIf('paketbiliard.form')

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
        url: '{{route('paketbiliard.data')}}',
     },
     columns:[
        {data:'DT_RowIndex', searchable:false, sortable:false},
        {data:'nama_paket'},
        {data:'harga'},
        {data:'durasi'},
        {data:'keterangan'},
        {data:'type'},
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
    $('#modal-form .modal-title').text('Tambah Paket Biliard');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('post');
    $('#modal-form [name=nama_paket]').focus();
    }
  }

  function editForm(url){
    $('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit Menu');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');
    $('#modal-form [name=nama_paket]').focus();

    $.get(url)
        .done((response)=>{
          $('#modal-form [name=nama_paket]').val(response.nama_paket);
          $('#modal-form [name=harga]').val(response.harga);
          $('#modal-form [name=keterangan]').val(response.keterangan);
          $('#modal-form [name=durasi]').val(response.durasi);
          $('#modal-form #option').val(response.type).change();
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

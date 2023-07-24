@extends('HalamanAwal.master')
@push('css')
<style>
tr, .dataTables_length, .dataTables_filter, select.form-control.input-sm, input.form-control.input-sm{
    font-size: 12t;
}
.btn-xs{font-size: 10pt;}
  tr:nth-child(even) {
  background-color: #cef0b1;
}
  thead{
  background-color: #96bf73;
  text-align: center;
}
.div-green {
  background-color: #35b50e;
  color: white;
  text-align: center;
}   
.div-red {
  background-color: #db1107;
  color: white;
  text-align: center;
}
.div-blue {
  background-color: #2c3b9e;
  color: white;
  text-align: center;
}
.Kosong {
  background-color: #35b50e;
  color: white;
  text-align: center;
  height: 50%;
  padding:0;
}
.Dipakai {
  background-color: #db1107;
  color: white;
  text-align: center;
  height: 50%;
  padding:0;
}
.Bayar {
  background-color: #2c3b9e;
  color: white;
  text-align: center;
  height: 50%;
  padding:0;
}
.btn-Dipakai, .btn-Bayar{display: none;}
   
</style>
@endpush
@section('title')
    Daftar Meja
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Meja</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <button onclick="addForm()" class="btn btn-success  btn-flat"><i class="fa fa-plus-circle">
              </i> Tambah</button>          
            </div>
            <div class="box-body table-responsive"  style="width:65%">
            <table class="table table-stiped table-bordered table-mejacafe">
              <thead>
                <th width="5%">No</th>
                <th>Nama Meja</th>
                <th>No.Order</th>
                <th>Status</th>
                <th width="20%"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody></tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
</div>

@includeIf('meja.meja')

@endsection

@push('scripts')
<script>
  let table,table2;

  $(function(){
   table= $('.table-mejacafe').DataTable({
     responsive:true,
     processing: true,
     serverSide: true,
     autoWidth:false,
     ajax: {
        url: '{{route('meja.data')}}',
     },
     columns:[
        {data:'DT_RowIndex', searchable:false, sortable:false},
        {data:'nama_meja'},
        {data:'Id_pesanan'},
        {data:'status'},
        {data:'aksi', searchable:false, sortable:false},
     ],
     bPaginate:false,
   }); 
   table2= $('.table-order').DataTable();

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
  
  function addForm(){
    $('#modal-form').modal('show');
  }

  function editForm(url){
    window.location = url;
    /*$('#modal-form').modal('show');
    $('#modal-form .modal-title').text('Edit Meja');

    $('#modal-form form')[0].reset();
    $('#modal-form form').attr('action', url);
    $('#modal-form [name=_method]').val('put');
    $('#modal-form [name=nama_meja]').focus();

    $.get(url)
        .done((response)=>{
          $('#modal-form [name=nama_meja]').val(response.nama_meja);
          $('#modal-form [name=Status]').val(response.Status);
        })
        .fail((errors)=>{
          alert('Tidak dapat menampilkan data');
          return;
        })*/
  }

  function resetform(url){
    if (confirm('Yakin ingin me-reset meja terpilih?')) {
    $.get(url)
    .done((response)=>{
      //table.ajax.reload();
      //table2.ajax.reload();
      location.reload();   
        })
    .fail((errors)=>{
    alert('Tidak dapat me-reset data');
    return;
        })
    }
  }
</script>
@endpush
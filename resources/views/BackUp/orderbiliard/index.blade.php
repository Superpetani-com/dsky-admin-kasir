@extends('HalamanAwal.master')
@push('css')
<style>
  tr, .dataTables_length, .dataTables_filter, select.form-control.input-sm, input.form-control.input-sm {
    font-size: 11pt;
}
  tr:nth-child(even) {
  background-color: #cef0b1;
}
  thead{
  background-color: #96bf73;
  }
  table{font-size: 11pt;}
  .btn-xs{font-size: 9pt;}
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
</style>
@endpush
@section('title')
    Daftar Order Biliard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">OrderBiliard</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
                      
            </div>
            <div class="box-body table-responsive">
            <table class="table table-orderbiliard table-stiped table-bordered">
              <thead>
                <th>Tanggal</th>
                <th>No.Order</th>
                <th>Customer</th>
                <th>Meja</th>
                <th>Jam</th>
                <th>Harga</th>
                <th>Diskon</th>
                <th>Bayar</th>
                <th>Diterima</th>
                <th>Kembali</th>
                <th>Status</th>
                <th width="10%"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody></tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
</div>

@endsection

@push('scripts')
<script>
  let table, table2;

  $(function(){
  $('body').addClass('sidebar-collapse');
   table= $('.table-orderbiliard').DataTable({
     responsive:true,
     processing: true,
     serverSide: true,
     autoWidth:false,
     "order": [[ 1, "desc" ]],
     ajax: {
        url: '{{route('orderbiliard.data')}}',
     },
     columns:[
        {data:'tanggal'},
        {data:'id_order_biliard'},
        {data:'customer'},
        {data:'meja'},
        {data:'totaljam'},
        {data:'totalharga'},
        {data:'diskon'},
        {data:'totalbayar'},
        {data:'diterima'},
        {data:'kembali'},
        {data:'status'},
        {data:'aksi', searchable:false, sortable:false},
     ]
     
   }); 
  });
    
  table2= $('.table-pesananbaru').DataTable();

  function addForm(){
    $('#modal-meja').modal('show');
    
  }

  function editForm(url){
    window.location = url;
    /*$('#modal-form').modal('show');
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
        })
        .fail((errors)=>{
          alert('Tidak dapat menampilkan data');
          return;
        })*/
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
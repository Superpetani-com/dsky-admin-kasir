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
    Daftar Meja Biliard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">MejaBiliard</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <button onclick="addForm('{{route('mejabiliard.store')}}')" class="btn btn-success  btn-flat"><i class="fa fa-plus-circle">
              </i> Order Baru</button>          
            </div>
            <div class="box-body table-responsive">
            <table class="table table-mejabiliard table-striped table-bordered dataTable">
              <thead>
                <th width="5%">No</th>
                <th>Meja</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Durasi</th>
                <th>Sisa Durasi</th>
                <th>No.Order</th>
                <th>Status</th>
                <th width="15%"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody></tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
</div>

@includeIf('mejabiliard.mejabiliard')

@endsection

@push('scripts')
<script>
  let table,table2;
  $(function() {
    $.get('{{route('mejabiliard.updatetime')}}')
    });
  $(function(){
   table= $('.table-mejabiliard').DataTable({
     responsive:true,
     processing: true,
     serverSide: true,
     autoWidth:false,
     ajax: {
        url: '{{route('mejabiliard.data')}}',
     },
     columns:[
        {data:'DT_RowIndex', searchable:false, sortable:false},
        {data:'namameja'},
        {data:'jammulai'},
        {data:'jamselesai'},
        {data:'durasi'},
        {data:'sisadurasi'},
        {data:'id_order_biliard'},
        {data:'status'},
        {data:'aksi', searchable:false, sortable:false},
     ],
     "lengthMenu": [[15, 10], [15, 10]]
   }); 
   table2= $('.table-orderbiliard').DataTable();

  });
  
  function addForm(url){
    $('#modal-form').modal('show');
    
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

  function editForm(url){
    window.location = url;
  }

  
  /*function editForm(url){
    $('#modal-form').modal('show');
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
    }*/
</script>
@endpush
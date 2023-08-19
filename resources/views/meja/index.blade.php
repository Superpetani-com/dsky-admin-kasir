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
    Daftar Meja Cafe
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
            @if(auth()->user()->level != 5)
            <div class="box-header with-border">
              <button onclick="addForm()" class="btn btn-success  btn-flat"><i class="fa fa-plus-circle">
              </i> Tambah</button>
            </div>
            @endif
            <p id="level" style="display: none;">{{auth()->user()->level}}</p>
            <div class="box-body table-responsive"  style="width:100%">
            <table class="table table-stiped table-bordered table-mejacafe">
              <thead>
                <th width="5%">No</th>
                <th>Nama Meja</th>
                <th>No.Order</th>
                @if(auth()->user()->level == 5)
                <th>Pesanan </th>
                @endif
                <th>Status</th>
                <th>Tanggal</th>
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
  let level = document.getElementById('level').innerHTML;

  console.log(level.innerHTML, 'level')
  $(function(){
   if(level == '5') {
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
        {
          "mData": "Id_pesanan",
          "mRender": function (data, type, row) {
            return `<a href='#'>${data}</a>`;
          }
        },
        {
          "mData": "pesanan_detail",
          "mRender": function (data, type, row) {
            let pesanan = '';
            data.map((item) => {
              pesanan += `${item.Nama_menu} (${item.jumlah}) , `
            });

            // Remove the trailing comma and space
            pesanan = pesanan.slice(0, -2);

            return `<ol>${pesanan.split(',').map(item => `<li>${item}</li>`).join('')}</ol>`;
          }
        },
        {data:'status'},
        {data:'updated_at', "render": function (data) {
          var date = new Date(data);
          var month = date.getMonth() + 1;
          return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes();
        }},
        {data:'aksi', searchable:false, sortable:false},
     ],
     bPaginate:false,
    });
   } else {
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
        {
          "mData": "Id_pesanan",
          "mRender": function (data, type, row) {
            return `<a href='{{ url('/pesanandetail/${data}') }}'>${data}</a>`;
          }
        },
        {data:'status'},
        {data:'updated_at', "render": function (data) {
          var date = new Date(data);
          var month = date.getMonth() + 1;
          return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes();
        }},
        {data:'aksi', searchable:false, sortable:false},
     ],
     bPaginate:false,
   });
   }
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

  function cancelform(url){
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

  function prosesform(url){
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

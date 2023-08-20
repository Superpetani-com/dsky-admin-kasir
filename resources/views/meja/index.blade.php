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
            <h1 id="new-order"></h1>
            <div class="box-body table-responsive"  style="width:100%">
            <table class="table table-stiped table-bordered table-mejacafe" id="table-mejacafe">
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

<audio id="alertSound">
    <source src="./sound.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>

<div class="modal fade" id="customAlert" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h1>Ada Order Masuk</h1>
            </div>
            <div class="modal-footer">
                <button id="okButton" type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
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

  function load(){
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
  };

  load(); // Call the load function initially

    var audioIsPlaying = false;

    function playAlertSound() {
        if (!audioIsPlaying) {
            var audio = document.getElementById("alertSound");
            audio.play();
            audioIsPlaying = true;

            // Once the audio finishes playing, reset the audioIsPlaying flag
            audio.addEventListener("ended", function() {
                audioIsPlaying = false;
            });
        }
    }
    function showAlert() {
        playAlertSound();
        $('#customAlert').modal('show');
    }

    // Create an interval that calls the load function every 3 seconds
    //   setInterval(load, 3000);
    var currentPath = window.location.pathname;
        var parts = currentPath.split('/');
        var lastPart = parts[parts.length - 1];


        if (lastPart == 'meja' && level == 5) {
        function getData(yt_url, callback) {
            $.ajax({
                type: "GET",
                url: yt_url,
                dataType: "json",
                success: callback,
                error: function(request, status, error) {
                    alert(status);
                }
            });
        }


        let isOk = true;

        setInterval(() => {
            let lastLength = 0;
            getData('{{route('meja.data')}}', function(response) {
                console.log(response.data.length, lastLength)
                if(response.data.length > lastLength  && isOk) {
                    console.log('order baru', response.data.length, lastLength)
                    showAlert()
                }
                // alert('The response was: ' + response.data.length, rowCount);
                // alert('Ada pesanan baru')
            });


            var tables = document.getElementById("table-mejacafe");
            lastLength = tables.rows.length;

            document.getElementById("okButton").addEventListener("click", function() {
                $('#customAlert').modal('hide');
                isOk = false;
            });

            console.log(isOk, 'ok')
        }, 3000);
        // setInterval(() => {
        //     if ($.fn.DataTable.isDataTable('.table-mejacafe')) {
        //         $('.table-mejacafe').DataTable().destroy();
        //     }
        //     load()
        // }, 3000);
    }



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
    if (confirm('Selesaikan Pesanan?')) {
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
    if (confirm('Cancel Pesanan?')) {
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
    if (confirm('Proses Pesanan?')) {
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

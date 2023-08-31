@extends('HalamanAwal.master')
@push('css')
<style>
tr, .dataTables_length, .dataTables_filter, select.form-control.input-sm, input.form-control.input-sm{
    font-size: 9pt;
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
  padding:2;
}
.Dipakai {
  background-color: #db1107;
  color: white;
  text-align: center;
  height: 50%;
  padding:2;
}
.Bayar {
  background-color: #2c3b9e;
  color: white;
  text-align: center;
  height: 50%;
  padding:2;
}
.btn-Dipakai, .btn-Bayar, .tr-dummy, .btnr-Kosong{display: none;}

.Diproses {
  background-color: #dac511;
  color: white;
  text-align: center;
  height: 50%;
  padding:2;
}

.Selesai {
  background-color: #110eb5;
  color: white;
  text-align: center;
  height: 50%;
  padding:2;
}

.card {
    background-color: #fff !important;
    border-radius: 10px;
    padding-left: 12px;
    padding-bottom: 12px;
    padding-top: 12px;
    padding-right: 12px;
    margin-top: 10px;
    box-shadow: 3px 3px 10px 0px rgba(0, 0, 0, 0.20);
    /* height: 260px; */
    /* max-height: 260px; */
    width: 190px;
}

.card-cafe {
    background-color: #fff !important;
    border-radius: 10px;
    padding-left: 12px;
    padding-bottom: 12px;
    padding-top: 12px;
    padding-right: 12px;
    margin-top: 10px;
    box-shadow: 3px 3px 10px 0px rgba(0, 0, 0, 0.20);
    margin-left: 50px;
}

.center {
    text-align: center;
}
p {
    margin: 0;
}
h3 {
    font-size: 42px;
    font-weight: bold;
    color: #000;
    margin-top: 0px !important;
}

h5 {
    font-weight: bold;
    color: #000;
}

.button-aksi {
    height: 30px;
    border: none;
    border-radius: 4px;
    font-size: 12px;
}

.bg-black {
    background-color: #121212;
}

.bg-blue {
    background-color: #0C6DFF !important;
}

.bg-red {
    background-color: #FF6961 !important;
    color: black !important;
}

.bg-red p {
    color: #000;
}

.bg-green {
    background: #30DB5B !important;
    color: black !important;
}

.bg-yellow {
    background: rgb(255, 204, 0) !important;
    color: black !important;
}

.rounded {
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 4px;
    padding-bottom: 4px;
    background: #fff;
    border-radius: 4px;
    margin-top: 4px;
}

.grid-container {
    margin-left: 10px;
    display: grid;
    grid-template-columns: repeat(8, 1fr); /* Creates 5 equal-width columns */
    gap: 10px; /* Adds spacing between grid items */
}

/* Media query for screens smaller than 1200px */
@media (max-width: 1200px) {
    .grid-container {
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
}

/* Media query for screens smaller than 992px */
@media (max-width: 992px) {
    .grid-container {
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }
}

/* Media query for screens smaller than 768px */
@media (max-width: 768px) {
    .grid-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }
}

/* Media query for screens smaller than 576px */
@media (max-width: 576px) {
    .grid-container {
        grid-template-columns: 1fr;
        gap: 5px;
    }
}

/* Media query for screens smaller than 480px */
@media (max-width: 480px) {
    .grid-container {
        grid-template-columns: 1fr; /* Single column for the smallest screens */
        gap: 5px; /* Further reduce gap for smallest screens */
    }
}

h1 {
    color: black;
    font-weight: bold;
}

h5 {
    margin: 0;
}

.table-meja td, .table-meja th {
    font-size: 16px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif'
}

</style>
@endpush
@section('title')
    DASHBOARD
@endsection

@section('breadcrumb')
    @parent
    <li class="active">DASHBOARD</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="box">
      <div class="row">
      <div class="col-md-8">
            <div class="box-header with-border">
              <h1>Order Meja Billiard</h1>
            </div>
      </div>
      <div class="col-md-4">

            <div class="box-header with-border">
                <div class="d-flex row">
                    <div class="col-md-6">
                      <h1 style="display: block;">Order Kafe</h1>
                    </div>
                    <div class="col-md-6">
                        <br>
                      <button onclick="addForm2()" class="btn btn-primary  btn-flat">
                          <i class="fa fa-plus-circle"></i> Order Cafe
                      </button>
                    </div>
                </div>
            </div>
      </div>
      </div>

      <div class="row">
          <div class="col-md-12 grid-container">
            @foreach ($mejabiliard as $key=>$item)
              <div class="grid-item">
                <div class="
                    @if($item->status == 'Dipakai')
                        {{ 'card bg-green' }}
                    @elseif($item->status == 'Bayar')
                        {{ 'card bg-red' }}
                    @elseif($item->status == 'Warning')
                        {{ 'card bg-yellow' }}
                    @else
                    {{'card'}}
                    @endif
                    ">
                    <h3 class="center">{{$key + 1}}</h3>
                    <h5 class="center rounded @if($item->status == 'Dipakai')
                        {{ 'bg-green' }}
                    @elseif($item->status == 'Bayar')
                        {{ 'bg-red' }}
                    @elseif($item->status == 'Warning')
                        {{ 'bg-yellow' }}
                    @endif">
                    @if($item->status == 'Dipakai')
                        {{ 'SEDANG DIPAKAI' }}
                    @elseif($item->status == 'Bayar')
                        {{ 'WAKTU HABIS' }}
                    @elseif($item->status == 'Warning')
                        {{ 'SEGERA SELESAI' }}
                    @else
                        {{ 'KOSONG' }}
                    @endif
                    </h5>
                    <p class="center">
                    @if ($item->order)
                        {{$item->order->customer}}
                    @endif</p>

                    @if($item->status !== 'Kosong')
                    <div style="display: flex; justify-content: space-between;" class="">
                        <div><p><b>Mulai</b></p></div>
                        <div><p>{{date("H:i:s", strtotime($item->jammulai))}}</p></div>
                    </div>
                    <div style="display: flex; justify-content: space-between;" class="">
                        <div><p><b>Selesai</b></p></div>
                        <div><p>{{date("H:i:s", strtotime($item->jamselesai))}}</p></div>
                    </div>
                    @if($item->flag == 1)
                        <div style="display: flex; justify-content: space-between;" class="">
                            <div><p><b>Durasi</b></p></div>
                            <div><p id="tddurasi{{$item->id_meja_biliard}}">{{$item->sisadurasi}}</p></div>
                        </div>
                    @else
                        <div style="display: flex; justify-content: space-between;" class="">
                            <div><p><b>Sisa</b></p></div>
                            <div><p id="tdsisadurasi{{$item->id_meja_biliard}}">{{$item->sisadurasi}}</p></div>
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between;margin-top: 10px;">
                        <button class="button-aksi bg-black" onclick="printNota({{$item->id_order_biliard}})">PRINT</button>
                        <div style="display: inline-flex">
                        @if($item->status == 'Dipakai')
                        <a href="{{route('orderbiliarddetail.index2', $item->id_order_biliard)}}">
                            <button class="button-aksi bg-blue">TAMBAH</button>
                        </a>
                        <button type="button" onclick="resetform2('{{route('mejabiliard.reset', $item->id_meja_biliard)}}', '{{$item->id_order_biliard}}','{{$item->flag}}')" class="button-aksi bg-red">SELESAI</button>
                        @elseif($item->status == 'Bayar' || $item->status == 'Warning')
                            <a href="{{route('orderbiliarddetail.index2', $item->id_order_biliard)}}">
                                <button class="button-aksi bg-blue">TAMBAH</button>
                            </a>
                            <button type="button" onclick="resetform2('{{route('mejabiliard.reset', $item->id_meja_biliard)}}', '{{$item->id_order_biliard}}','{{$item->flag}}')" class="button-aksi bg-red">SELESAI</button>
                        @endif
                        </div>
                    </div>

                    @else
                    <br>
                    <a href="{{route('orderbiliard.create', $item->id_meja_biliard)}}">
                        <h5 class="center"><button class="button-aksi bg-blue">TAMBAH</button></h5>
                    </a>
                    <br>
                    @endif


                </div>
              </div>
            @endforeach

          </div>

          {{-- <div class="col-md-3">
            <div class="box-body table-responsive">
              <table class="table table-meja table-striped table-bordered table-meja">
                <thead>
                  <th>Meja</th>
                  <th>Customer</th>
                  <th>Bayar</th>
                  <th>Order</th>
                  <th>Status</th>
                </thead>

              </table>
            </div>
          </div> --}}

          {{-- <div class="col-md-3">
            <div class="row">
                <div class="card-cafe center">
                    <h3 class="center">1</h3>
                    <h5 class="center">KOSONG</h5>
                    <br>
                    <button class="button-aksi bg-blue center">TAMBAH</button>
                </div>
                <div class="card-cafe center bg-green">
                    <h3 class="center">2</h3>
                    <h5 class="center">DIPROSES</h5>
                    <button class="button-aksi bg-blue center">TAMBAH</button>
                </div>
                <div class="card-cafe center bg-red">
                    <h3 class="center">3</h3>
                    <h5 class="center">BELUM BAYAR</h5>
                    <button class="button-aksi bg-blue center">SELESAI</button>
                </div>
                <div class="card-cafe center">
                    <h3 class="center">3</h3>
                    <h5 class="center">KOSONG</h5>
                    <button class="button-aksi bg-blue center">TAMBAH</button>
                </div>
            </div>
          </div> --}}
      </div>
      <br><br>
      <div class="row">
        <div class="col-md-7">
        <div class="box-body table-responsive">
        <table class="table table-mejabiliard table-striped table-bordered">

        @foreach ($mejabiliard as $key=>$item)
        <tr class="tr-dummy">
          <td>{{$item->namameja}}</td>
          <td>{{$item->jammulai}}</td>
          <td>{{$item->jamselesai}}</td>
          <td id="tddurasidummy{{$item->id_meja_biliard}}">{{$item->durasi}} Menit</td>
          <td id="tdsisadurasidummy{{$item->id_meja_biliard}}">{{$item->sisadurasi}} Menit</td>
          <td>{{$item->id_order_biliard}}</td>
          <td width="12%">
            <a href="" class="btn btn-xs btn-flat {{$item->status}}">{{$item->status}}</a>
          </td>
        </tr>
        @endforeach
          </tbody>
        </table>
        </div>
        </div>

  </div>
      <p id="level" style="display: none;">{{auth()->user()->level}}</p>

</div>
@includeIf('dashboard.mejabiliard')
@includeIf('dashboard.meja')

@endsection

@push('scripts')
<script>
  let level = document.getElementById('level').innerHTML;
  function stopseting(iddetail, idmeja, totalflag){
    if (confirm('Yakin ingin berhenti MANUAL?')) {
        $.get(`{{url('orderbiliarddetail')}}/${iddetail}/${idmeja}/0/stop`)
        .done((response) => {table.ajax.reload();})
        .fail((errors)   => {
                        alert('Tidak dapat menghapus data');
                        return;
                        });
    }
  }
function load(){
    table= $('.table-meja').DataTable({
        "bDestroy": true,

     responsive:true,
     processing: true,
     serverSide: true,
     autoWidth:false,
     searching: false,
     "ordering": false,
     error: function(xhr, textStatus, errorThrown) {
                console.log('Ajax error:', textStatus, errorThrown);
            },
     ajax: {
        url: '{{route('dashboard.indexDataMeja')}}',
     },
     columns:[
        {data:'nama_meja'},
        // {
        //             "mData": "pesanan",
        //             "mRender": function (data, type, row) {
        //                 if(data) {
        //                     return data.customer
        //                 }
        //             }
        //         },
        // {data:'pesanan.TotalBayar'},
        // {data:'Id_pesanan'},
        {
                    "mData": "Status",
                    "mRender": function (data, type, row) {

                        if(data == 'Dipakai') {
                            if({{auth()->user()->level == 1}}) {
                                return `<a class="btn btn-xs btn-flat ${data}" href='{{ url('/pesanandetail/${row.Id_pesanan}') }}'>Menunggu Kitchen</a>`;

                            } else {
                                return `<a class="btn btn-xs btn-flat ${data}" href='{{ url('/pesanandetail/${row.Id_pesanan}') }}'>Sedang Diproses</a>`;

                            }
                        } else if(data == "Diproses") {
                            return `<a class="btn btn-xs btn-flat ${data}" href='{{ url('/pesanandetail/${row.Id_pesanan}') }}'>Diproses Kitchen</a>`;
                        } else {
                            return `<a class="btn btn-xs btn-flat ${data}"href='{{ url('/pesanandetail/${row.Id_pesanan}') }}'>${data}</a>`;
                        }
                    }
                },
     ],
     columnDefs: [{
    "defaultContent": "",
    "targets": "_all"
  }],
     bPaginate:false,
    });
}

    load();
    $.fn.dataTable.ext.errMode = 'none';

    var currentPath = window.location.pathname;
    var parts = currentPath.split('/');
    var lastPart = parts[parts.length - 1];

    if(level == 1 && lastPart == 'dashboard') {
            setInterval(() => {
            load();
        }, 3000);
    }


function addForm1(){$('#modal-form1').modal('show');  }
function addForm2(){$('#modal-form2').modal('show');  }

function printNota(id) {
    var urlcetak=(`{{url('orderbiliard')}}/cetak/${id}`);
    cetak(urlcetak);
}

function printNotaKitchen(id) {
    var urlcetak=(`{{url('orderbiliard')}}/cetak-kitchen/${id}`);
    console.log(id, 'askdansdk')
    cetak(urlcetak);
}

function resetform2(url, id, flag){
  if(flag>0){
    if (confirm('Stop dan Simpan Jam Manual Dahulu')) {
    var urldetail=(`{{url('orderbiliarddetail')}}/${id}/before`);
    location.replace(urldetail)
  }
  }

    if(flag==0){
        if (confirm('Yakin ingin me-reset meja terpilih?')) {
        var urlcetak=(`{{url('orderbiliard')}}/cetak/${id}`);
        cetak(urlcetak);
        // Introduce a delay of 2 seconds
        setTimeout(() => {
            $.get(url)
                .done((response) => {
                location.reload();
            }).fail((errors) => {
                alert('Tidak dapat me-reset data');
                return;
            });
        }, 2000); // 2000 milliseconds = 2 seconds
    }
  }
}
  function resetform1(url, id){
    if (confirm('Yakin ingin me-reset meja terpilih?')) {
    var urlcetak=(`{{url('pesanan')}}/cetak/${id}`);
    cetak(urlcetak);
    $.get(url)
    .done((response)=>{
    //   location.reload();
    })
    .fail((errors)=>{
    alert('Tidak dapat me-reset data');
    return;
        })
    }
  }
$.get('{{route('mejabiliard.updatetime')}}');
$('body').addClass('sidebar-collapse');
let i;
i = 0;

const myInterval1 = setInterval(myTimer1, 1000);

function myTimer1() {
    i = i + 1;
      @foreach ($mejabiliard as $key=>$item)
      var status="{{$item->status}}";
      var sd = document.getElementById("tdsisadurasidummy{{$item->id_meja_biliard}}").innerHTML;
      var sdcomma=sd.indexOf(",");
      var d = document.getElementById("tddurasidummy{{$item->id_meja_biliard}}").innerHTML;
      var dcomma=d.indexOf(",");
      if(sd=="99999 Menit"){
          var dnumber=d.slice(0, (dcomma+3)).replace(".", "");
              dnumber=(Number(dnumber.replace(",", ".")))*60+i;
          var h = Math.floor(dnumber / 3600);
          h=checkTime(h);
          var m = Math.floor(dnumber % 3600 / 60);
          m=checkTime(m);
          var s = Math.floor(dnumber % 3600 % 60);
          s=checkTime(s);
          document.getElementById("tddurasi{{$item->id_meja_biliard}}").innerHTML=h+":"+m+":"+s;
      }

      if(sd!="99999 Menit" && (status=="Dipakai" || status == "Warning")){
          var sdnumber=((Number((sd.slice(0, (sdcomma+3))).replace(",", ".")))*60)-i;
          console.log(sdnumber);
          if(sdnumber<0){
            location.reload();
          }

          if(sdnumber >= 598 && sdnumber <= 600) {
            location.reload();
          }

          if(sdnumber>0){
          var h = Math.floor(sdnumber / 3600);
          h=checkTime(h);
          var m = Math.floor(sdnumber % 3600 / 60);
          m=checkTime(m);
          var s = Math.floor(sdnumber % 3600 % 60);
          s=checkTime(s);
          document.getElementById("tdsisadurasi{{$item->id_meja_biliard}}").innerHTML=h+":"+m+":"+s;
          }

      }
      @endforeach
    }

function checkTime(g) {
  if (g < 10) {g = "0" + g};  // add zero in front of numbers < 10
  return g;
}

function cetak(url, title) {
    popupCenter(url, title, 625, 500);
    function popupCenter(url, title, w, h) {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop  = window.screenTop  !==  undefined ? window.screenTop  : window.screenY;
        const width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        const systemZoom = width / window.screen.availWidth;
        const left       = (width - w) / 2 / systemZoom + dualScreenLeft
        const top        = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow  = window.open(url, title,
        `
            scrollbars=yes,
            width  = ${w / systemZoom},
            height = ${h / systemZoom},
            top    = ${top},
            left   = ${left}
        `
        );
        if (window.focus) newWindow.focus();
        if (newWindow) {
            setTimeout(() => {
                newWindow.close();
            }, 1000); // Wait for 2000 milliseconds (2 seconds)
        }
    }
}


</script>
@endpush

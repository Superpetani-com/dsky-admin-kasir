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
      <div class="col-md-7">
            <div class="box-header with-border">
              <button onclick="addForm1()" class="btn btn-success  btn-flat"><i class="fa fa-plus-circle">
              </i> Order Biliard</button>          
            </div>
      </div>
      <div class="col-md-5">
            <div class="box-header with-border">
              <button onclick="addForm2()" class="btn btn-primary  btn-flat"><i class="fa fa-plus-circle">
              </i> Order Cafe</button>          
            </div>
      </div>      
      </div>
      <div class="row">
            <div class="col-md-7">
            <div class="box-body table-responsive">
            <table class="table table-mejabiliard table-striped table-bordered">
              <thead>
                <th>Meja</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Durasi</th>
                <th>Sisa Durasi</th>
                <th>Customer</th>
                <th>Bayar</th>
                <th>Order</th>
                <th>Status</th>
              </thead>
              <tbody>
              @foreach ($mejabiliard as $key=>$item)
            <tr>
              <td>{{$item->namameja}}</td>
              <td>{{$item->jammulai}}</td>
              <td>{{$item->jamselesai}}</td>
              <td id="tddurasi{{$item->id_meja_biliard}}">{{$item->durasi}} Menit</td>
              <td id="tdsisadurasi{{$item->id_meja_biliard}}">{{$item->sisadurasi}} Menit</td>
              <td>{{$item->order['customer']}}</td>
              <td>Rp. {{number_format(($item->order['totalbayar']), 0,",",".")}}</td>
              <td>{{$item->id_order_biliard}}</td>
              <td width="12%">
                <a href="{{route('orderbiliarddetail.index2', $item->id_order_biliard)}}" class="btn btn-xs btn-flat {{$item->status}}" id="tdstatus{{$item->id_meja_biliard}}">
                  {{$item->status}}
                </a>
              </td>
            </tr>
            @endforeach
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
        <div class="col-md-5">
          <div class="box-body table-responsive">
            <table class="table table-meja table-striped table-bordered">
              <thead>
                <th>Meja</th>
                <th>Customer</th>
                <th>Bayar</th>
                <th>Order</th>
                <th>Status</th>
              </thead>
              <tbody>
              <tbody>
              @foreach ($meja as $key1=>$item1)
              <tr>
              <td>{{$item1->nama_meja}}</td>
              <td>{{$item1->pesanan['customer']}}</td>
              <td>Rp. {{ number_format(($item1->pesanan['TotalBayar']), 0,",",".")}}</td>
              <td>{{$item1->Id_pesanan}}</td>
              <td width="12%">
                <a href="{{route('pesanandetail.index2', $item1->Id_pesanan)}}" class="btn btn-xs btn-flat {{$item1->Status}}">
                  {{$item1->Status}}
                </a>
              </td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>
      
</div>
@includeIf('dashboard.mejabiliard')
@includeIf('dashboard.meja')

@endsection

@push('scripts')
<script>

function addForm1(){$('#modal-form1').modal('show');  }
function addForm2(){$('#modal-form2').modal('show');  }
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
    $.get(url)
    .done((response)=>{
      location.reload();   
        })
    .fail((errors)=>{
    alert('Tidak dapat me-reset data');
    return;
        })
    }
  }

  }
  function resetform1(url, id){
    if (confirm('Yakin ingin me-reset meja terpilih?')) {
    var urlcetak=(`{{url('pesanan')}}/cetak/${id}`);
    cetak(urlcetak);
    $.get(url)
    .done((response)=>{
      location.reload();   
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
      if(sd!="99999 Menit" && status=="Dipakai"){
          var sdnumber=((Number((sd.slice(0, (sdcomma+3))).replace(",", ".")))*60)-i;
          console.log(sdnumber);
          if(sdnumber<0){
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

    }

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
    }


</script>
@endpush
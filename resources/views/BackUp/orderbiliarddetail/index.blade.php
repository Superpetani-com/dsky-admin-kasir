@extends('HalamanAwal.master')

@section('title')
    Order Biliard
@endsection

@push('css')
<style>
  .form-paket, .btn-hapus, .btn-stop, .btn-simpan, .btn-cetak, .btn-tambah,.btn-pindah,.btn-cetakselesai{
    font-size:12pt;
  }
  .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }
  .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
        font-size: 12pt;
    }
  .table-order tbody tr:last-child {
        display:none;
    }
  .table-order tbody tr:nth-child(even) {
  background-color: #cef0b1;
    } 
  .table-order  thead{background-color: #96bf73;}
  .table-mejabiliard tbody tr:nth-child(even) {
  background-color: #cef0b1;
    } 
  .table-mejabiliard  thead{background-color: #96bf73;}
  table{font-size: 12pt;}
  input[type="text"]{font-size:12pt;}
  input[type="number"]{font-size:12pt;}
  .form-order{font-size: 12pt;}
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

  @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
    
</style>
@endpush
@section('breadcrumb')
    @parent
    <li class="active">OrderBiliardDetail</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <table>
                <tr>
                  <td>Meja Biliard</td>
                  <td>:{{$mejabiliard->namameja}}</td>
                </tr>
                <tr>
                  <td>Nomor Order</td>
                  <td>:{{$id_order_biliard}}</td>
                </tr>
              </table>         
            </div>
            <div class="box-body">
                <form class="form-paket">
                  @csrf  
                  <!--div class="form-group row">
                    <label for="nama_paket" class="col-lg-2">Tambah Jam</label>
                    <div class="col-lg-5">
                      <div class="input-group">
                        <input type="hidden" name="id_paket_biliard" id="id_paket_biliard">
                        <input type="hidden" name="id_order_biliard" id="id_order_biliard" value="{{$id_order_biliard}}">
                        <input type="text" class="form-control" name="nama_paket" id="nama_paket">
                        <span class="input-group-btn">
                          <button onclick="tampilpaket()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                        </span>
                      </div>
                    </div>
                  </div-->
                  <div class="form-group row">
                  <div class="input-group">
                    <input type="hidden" name="id_paket_biliard" id="id_paket_biliard">
                    <input type="hidden" name="id_order_biliard" id="id_order_biliard" value="{{$id_order_biliard}}">
                    <input type="hidden" name="seting_paket" id="seting_paket">
                  </div>  
                  <label for="nama_cust" class="col-lg-1">Customer</label>
                  <div class="col-lg-3">
                    <input type="text" class="form-control" name="nama_cust" id="nama_cust" maxlength="50" value="{{$order->customer}}" required> 
                    <span class="help-block with-errors"></span>
                  </div>
                  <div class="input-group-btn">
                     <button onclick="tampilpaket()" class="btn btn-info btn-tambah" type="button"><i class="fa fa-plus-circle"></i> Tambah Jam</button>
                     <button onclick="tampilmeja()" class="btn btn-danger btn-pindah" type="button"><i class="fa fa-arrows"></i> Pindah Meja</button>
                  </div>        
                </form>
              </div>
              <table class="table table-stiped table-bordered table-order">
                <thead>
                  <th width="4%">No</th>
                  <th>Nama Paket</th>
                  <th>Harga</th>
                  <th width="10%">Jumlah</th>
                  <th>Menit</th>
                  <th> SubTotal</th>
                  <th> Seting</th>
                  <th width="4%"> </th>
                  <th width="4%"> </th>
                </thead>
                <tbody></tbody>
              </table>
              <div class="row">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary"></div>
                        <div class="tampil-terbilang"></div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('orderbiliard.store') }}" class="form-order" method="post">
                            @csrf
                            <input type="hidden" name="id_order_biliard"  value="{{ $id_order_biliard }}">
                            <input type="hidden" name="total" id="total" value="{{ $order->totalharga }}">
                            <input type="hidden" name="total_jam" id="total_jam">
                            <input type="hidden" name="total_menit" id="total_menit">
                            <input type="hidden" name="total_flag" id="total_flag" value="0">
                            <input type="hidden" name="bayar" id="bayar">
                            <input type="hidden" name="kembali" id="kembali">
                            <input type="hidden" name="id_meja_biliard" id="id_meja_biliard" value="{{ $mejabiliard->id_meja_biliard }}">
                            <input type="hidden" name="status_meja_biliard" id="status_meja_biliard" value="{{ $mejabiliard->status }}">
                            <input type="hidden" name="status_order_biliard" id="status_order_biliard" value="{{ $order->status }}">
                            <input type="hidden" name="nama_cust2" id="nama_cust2" value="{{$order->customer}}">
                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-3 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diskon" class="col-lg-3 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control" value="{{ $order->diskon }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayarrp" class="col-lg-3 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diterima" class="col-lg-3 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diterima" id="diterima" class="form-control" value="{{ $order->diterima }}">
                               </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembalirp" class="col-lg-3 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembalirp" class="form-control" readonly>
                               </div>
                            </div>
                            
                          </form>
                        </div>
                      </div>
                    </div>
              <div class="box-footer p-3">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan "><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
                <button type="submit" class="btn btn-warning btn-sm btn-flat pull-right btn-cetak "><i class="fa fa-print"></i> Cetak Transaksi</button>
                <!--button type="submit" class="btn btn-danger btn-sm btn-flat pull-right btn-cetakselesai "><i class="fa fa-check"></i> Cetak & Selesai</button-->
            </div>
        </div>
    </div>
</div>

@includeIf('orderbiliarddetail.mejabilliard')
@includeIf('orderbiliarddetail.paket')

@endsection

@push('scripts')
<script>
  let table, table2;

  $(function(){
   table= $('.table-order').DataTable({
     responsive:true,
     processing: true,
     serverSide: true,
     autoWidth:false,
     ajax: {
        url: '{{route('orderbiliarddetail.data', [$id_order_biliard, $mejabiliard->status, $order->status])}}',
     },
     columns:[
        {data:'DT_RowIndex', searchable:false, sortable:false},
        {data:'nama_paket'},
        {data:'harga'},
        {data:'jumlah'},
        {data:'menit'},
        {data:'subtotal'},
        {data:'seting'},
        {data:'aksi', searchable:false, sortable:false},
        {data:'aksi2', searchable:false, sortable:false},
     ],
     dom:'Brt',
     bSort: false,
     "lengthMenu": [[-1], ["All"]]
     
   })
   .on('draw.dt', function(){
     setTimeout(() => {
            $('#diterima').trigger('input');
            }, 400);

   });

   table2= $('.table-paket').DataTable();

    $(document).on('input', '#diskon', debounce(function() {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }
            loadform($(this).val(), $('#diterima').val());
        },300));
  
    $('#diterima').on('input', debounce(function() {
            if ($(this).val() == "") {
                $(this).val(0).select();
          }
          loadform($('#diskon').val(), $(this).val());
        },300));
       
    $('#nama_cust').change(function() {
    $('#nama_cust2').val($(this).val());
    });

    $('.btn-simpan').on('click', function () {
      var myInput = document.getElementById("nama_cust");
      if (myInput.value=="") {
      alert("Nama Customer Harus Diisi");
      return false;
      }
      $('.form-order').submit();
        });
    
    $('.btn-cetak').on('click', function () {
     
    $('.form-order').submit();
    cetak('{{ route('orderbiliard.cetak', $id_order_biliard) }}', 'Nota');  
        });
    
    $('.btn-cetakselesai').on('click', function () {
    $('.form-order').submit();
    cetak('{{ route('orderbiliard.cetak', $id_order_biliard) }}', 'Nota');
    $.get('{{route('mejabiliard.reset', $mejabiliard->id_meja_biliard)}}');  
        });
    
      
  });

  const debounce = (func, wait, immediate)=> {
    var timeout;
    return function executedFunction() {
        var context = this;
        var args = arguments;
            
        var later = function() {
        timeout = null;
        if (!immediate) func.apply(context, args);
        };

        var callNow = immediate && !timeout;
        
        clearTimeout(timeout);

        timeout = setTimeout(later, wait);
        
        if (callNow) func.apply(context, args);
        };
    }; 
$(document).on('input','.quantity', debounce(function(){
     let id=$(this).data('id');
     let jumlah=($(this).val());
     
     if(jumlah<0.00){
        alert('Jumlah tidak boleh kurang dari 0.00');
        $(this).val(0.05);
        return;
     }
     if(jumlah>2000){
        alert('Jumlah tidak boleh melebihi 2000');
        $(this).val(2000);
        return;
     }

     $.post (`{{url('/orderbiliarddetail')}}/${id}`,{
      '_token': $('[name=csrf-token]').attr('content'),
      '_method': 'put',
      'jumlah':jumlah
     })
     .done(response=>{
        loadform($('#diskon').val(), $('#diterima').val());
        table.ajax.reload();       
      })
      .fail(errors=>{
        alert('Tidak dapat menyimpan data');
        return;
      });
    },300));
  
  function tampilmeja(){
    let status2=($('#status_order_biliard').val());
    if (status2=="Aktif"){
    $('#modal-form1').modal('show');
    }
  }

  function tampilpaket(){
    let status1=($('#status_meja_biliard').val());
    let status2=($('#status_order_biliard').val());
    if (status2=="Aktif"){
    $('#modal-paket').modal('show');
    }
    }

  function hidepaket(){
    $('#modal-paket').modal('hide');
    
  }

  function pilihpaket(id, nama){ 
    $('#id_paket_biliard').val(id);
    $('#nama_paket').val(nama);
    $('#seting_paket').val($('.seting').val());
    hidepaket()
    tambahpaket()
  }

  function tambahpaket(){
    setTimeout(() => {
    $.post('{{route('orderbiliarddetail.store')}}', $('.form-paket').serialize())
      .done(response=>{
        $('#nama_paket').focus();
        table.ajax.reload();
      })
      .fail(errors=>{
        alert('Tidak dapat menyimpan data');
        return;
      })
    },500);
  }

  function deleteData(url) {
        if (confirm('Yakin ingin MENGAHPUS DATA terpilih?')) {
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

  function stopseting(iddetail){
  let totalflag=($('.total_flag').text());
  let idmeja=($('#id_meja_biliard').val());
  if (confirm('Yakin ingin berhenti MANUAL?')) {
    $.get(`{{url('orderbiliarddetail')}}/${iddetail}/{{$mejabiliard->id_meja_biliard}}/${totalflag}/stop`)
    .done((response) => {table.ajax.reload();})
    .fail((errors)   => {
                    alert('Tidak dapat menghapus data');
                    return;
                    });
    } 
  }

  function loadform(diskon = 0, diterima = 0){
    $('#total').val($('.total').text());
    $('#total_jam').val($('.total_jam').text());
    $('#total_menit').val($('.total_menit').text());
    $('#total_flag').val($('.total_flag').text());
    $.get(`{{ url('/orderbiliarddetail/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
    .done(response => {
                $('#totalrp').val('Rp. '+ response.totalrp);
                $('#bayarrp').val('Rp. '+ response.bayarrp);
                $('#bayar').val(response.bayar);
                $('#kembali').val(response.kembali);
                $('.tampil-bayar').text('Bayar: Rp. '+ response.bayarrp);
                $('.tampil-terbilang').text('Terbilang: '+response.terbilang);
                $('#kembalirp').val('Rp.'+ response.kembalirp);
                if ($('#diterima').val() != 0) {
                    $('.tampil-bayar').text('Kembali: Rp. '+ response.kembalirp);
                    $('.tampil-terbilang').text(response.kembali_terbilang);
                }
      })
    .fail(errors => {
                alert('Tidak dapat menampilkan data');
                $('#diterima').trigger('input');
                return;
  })

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
@extends('HalamanAwal.master')

@section('title')
    Order Biliard
@endsection

@push('css')
<style>
      .table-pesanan tbody tr:last-child {
        display:none;
    }

    .button-aksi {
        height: 40px;
        border: none;
    }

    .bg-black {
        background: rgb(255, 204, 0) !important;
    }
  .table-pesanan tbody tr:nth-child(even) {
  background-color: #cef0b1;
    }
  .table-pesanan  thead{background-color: #96bf73;}
  .table-pesanan tbody tr:last-child {
        display:none;
    }
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
                     <button onclick="tampilmenu()" class="btn btn-success btn-pindah" type="button"><i class="fa fa-plus"></i> Tambah Menu Cafe</button>
                  </div>
                </form>
                <form class="form-menu">
                    @csrf
                    <!--div class="form-group row">
                      <label for="nama_menu" class="col-lg-2">Tambah Menu</label>
                      <div class="col-lg-5">
                        <div class="input-group">
                          <input type="hidden" name="id_menu" id="id_menu">
                          <input type="hidden" name="id_pesanan" id="id_pesanan" value="{{$Id_pesanan}}">
                          <input type="text" class="form-control" name="nama_menu" id="nama_menu">
                        </div>
                      </div>
                    </div-->
                    <div class="form-group row">
                    <input type="hidden" name="id_menu" id="id_menu">
                    <input type="hidden" name="id_pesanan" id="id_pesanan" value="{{$Id_pesanan}}">
                      {{-- <label for="nama_cust" class="col-lg-1">Customer</label> --}}
                      {{-- <div class="col-lg-3">
                        <input type="text" class="form-control" name="nama_cust" id="nama_cust" maxlength="50" value="{{$pesanan->customer}}" required>
                        <span class="help-block with-errors"></span>
                      </div>
                      <div class="input-group-btn">
                            <button onclick="tampilmenu()" class="btn btn-info btn-flat btn-tambah" type="button"><i class="fa fa-plus-circle"></i> Tambah Menu</button>
                      </div> --}}
                      </div>
                  </form>
              </div>
              <table class="table table-stiped table-bordered table-order">
                <h3>Order Meja Billiard</h3>

                <thead>
                  <th width="4%">No</th>
                  <th>Nama Paket</th>
                  <th>Harga</th>
                  <th width="10%">Jumlah</th>
                  <th>Menit</th>
                  <th>Sisa Durasi</th>
                  <th> SubTotal</th>
                  <th> Seting</th>
                  <th width="4%"> </th>
                  <th width="4%"> </th>
                </thead>
                <tbody></tbody>
              </table>
              <table class="table table-stiped table-bordered table-pesanan">
                  <h3>Pesanan Cafe</h3>
                <thead>
                  <th width="5%">No</th>
                  <th>Menu</th>
                  <th>Harga</th>
                  <th width="15%">Jumlah Item</th>
                  <th>SubTotal</th>
                  <th width="15%"><i class="fa fa-cog"></i></th>
                </thead>
                <tbody></tbody>
              </table>
              <div class="row">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary"></div>
                        <div class="tampil-terbilang"></div>
                    </div>
                    <div class="col-lg-4">
                        {{-- {{dd($order);}} --}}
                        <form action="{{ route('pesanan.store') }}" class="form-pesanan" method="post">
                            @csrf
                            <input type="hidden" name="id_meja_cafe" id="id_meja_cafe" value="{{ $meja->id_meja }}">
                            <input type="hidden" name="status_meja" id="status_meja" value="{{ $meja->Status }}">
                            <input type="hidden" name="status_pesanan" id="status_pesanan" value="{{ $pesanan->status }}">
                            <input type="hidden" name="nama_cust2" id="nama_cust2" value="{{$pesanan->customer}}">
                            <input type="hidden" name="id_pesanan" value="{{ $Id_pesanan }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="#">
                            <input type="hidden" name="kembali" id="kembali" value="0">
                            <input type="hidden" name="ppn" id="ppn" value="0">
                            <input type="hidden" name="diterima" value="0">
                            {{-- <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div> --}}
                            <!-- <div class="form-group row">
                                <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control" value="{{ $pesanan->Diskon }}">
                                </div>
                            </div> -->
                            {{-- <div class="form-group row">
                                <label for="ppnrp" class="col-lg-2 control-label">PPN 10%</label>
                                <div class="col-lg-8">
                                    <input type="text" name="ppnrp" id="ppnrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control" readonly>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                {{-- <label for="diterima" class="col-lg-2 control-label">Diterima</label> --}}
                                {{-- {{dd($pesanan);}} --}}
                                <div class="col-lg-8">
                                    <input type="hidden" name="diterima" id="diterima" class="form-control">
                               </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="kembalirp" class="col-lg-2 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembalirp" class="form-control" readonly>
                               </div>
                            </div> --}}

                          </form>
                        </div>
                        <form action="{{ route('orderbiliard.store') }}" class="form-order" id="form_order" method="post">
                            @csrf
                            <input type="hidden" name="id_order_biliard"  value="{{ $id_order_biliard }}">
                            <input type="hidden" name="total" id="total" value="{{ $order->totalharga }}">
                            <input type="hidden" name="total_jam" id="total_jam">
                            <input type="hidden" name="total_menit" id="total_menit">
                            <input type="hidden" name="total_flag" id="total_flag" value="0">
                            <input type="hidden" name="bayar" id="bayar" class="totalbil">
                            <input type="hidden" name="kembali" id="kembali">
                            <input type="hidden" name="id_meja_biliard" id="id_meja_biliard" value="{{ $mejabiliard->id_meja_biliard }}">
                            <input type="hidden" name="status_meja_biliard" id="status_meja_biliard" value="{{ $mejabiliard->status }}">
                            <input type="hidden" name="status_order_biliard" id="status_order_biliard" value="{{ $order->status }}">
                            <input type="hidden" name="nama_cust3" id="nama_cust3" value="{{$pesanan->customer}}">
                            {{-- <div class="form-group row">
                                <label for="totalrp" class="col-lg-3 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div> --}}
                            <!-- <div class="form-group row">
                                <label for="diskon" class="col-lg-3 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control" value="{{ $order->diskon }}">
                                </div>
                            </div> -->
                            {{-- <div class="form-group row">
                                <label for="bayarrp" class="col-lg-3 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control" readonly>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                {{-- <label for="diterima" class="col-lg-3 control-label">Diterima</label> --}}
                                <div class="col-lg-8">
                                    <input type="hidden" name="diterima" id="diterima" class="form-control" value="{{ $order->diterima }}">
                               </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="kembalirp" class="col-lg-3 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembalirp" class="form-control" readonly>
                               </div>
                            </div> --}}

                          </form>
                        </div>
                      </div>
                    </div>
              <div class="box-footer p-3">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan "><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
                @if($count_pesanan_detail > 0)
                <button class="button-aksi bg-black pull-right" style="margin-right: 10px;" onclick="printNotaKitchen({{$id_order_biliard}})">PRINT KITCHEN</button>
                @endif
                {{-- <button type="submit" class="btn btn-warning btn-sm btn-flat pull-right btn-cetak "><i class="fa fa-print"></i> Cetak Transaksi</button> --}}
                <!--button type="submit" class="btn btn-danger btn-sm btn-flat pull-right btn-cetakselesai "><i class="fa fa-check"></i> Cetak & Selesai</button-->
            </div>
        </div>
    </div>
</div>

@includeIf('orderbiliarddetail.mejabilliard')
@includeIf('orderbiliarddetail.paket')
@includeIf('orderbiliarddetail.menu')
@includeIf('orderbiliarddetail.delete')
@includeIf('orderbiliarddetail.confirmation')
@includeIf('orderbiliarddetail.delete_menu')

@endsection

@push('scripts')
<script>
  let table, table2, table3;



  $(function(){
    const idPesananValue = document.getElementById('id_pesanan').value;
    const pesananStatus = '{{ $pesanan->status ?? "Aktif" }}';
    const url = '{{ route('pesanandetail.data', [$Id_pesanan, "REPLACE_STATUS"]) }}';
    const finalUrl = url.replace("REPLACE_STATUS", pesananStatus);

    table3= $('.table-pesanan').DataTable({
        responsive:true,
        processing: true,
        serverSide: true,
        autoWidth:false,
        ajax: {
            url: finalUrl,
        },
        columns:[
            {data:'DT_RowIndex', searchable:false, sortable:false},
            {data:'nama_menu'},
            {data:'harga'},
            {data:'jumlah'},
            {data:'subtotal'},
            {data:'aksi', searchable:false, sortable:false},
        ],
        dom:'Brt',
        bSort: false,
        "lengthMenu": [[-1], ["All"]]
        })
        .on('draw.dt', function(){
            loadform($('#diskon').val());
            setTimeout(() => {
                        $('#diterima').trigger('input');
                    }, 300);

    });
    $.fn.dataTable.ext.errMode = 'none';

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
        {data:'sisadurasi'},
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
   table2= $('.table-menu').DataTable();
   $.fn.dataTable.ext.errMode = 'none';

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
        $('#nama_cust3').val($(this).val());
    });

    $('.btn-simpan').on('click', async function () {
      var myInput = document.getElementById("nama_cust");
      if (myInput.value=="") {
      alert("Nama Customer Harus Diisi");
      return false;
      }

        // Submit the first form
        $.post($('.form-order').attr('action'), $('.form-order').serialize(), function(response) {
            if(response.status) {
                // Wait for a certain time before submitting the second form
                // setTimeout(function() {
                    $('.form-pesanan').submit();
                // }, 2000); // 2000 milliseconds (2 seconds) delay
            }
            console.log(response.status); // Process the response here
        });

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
    function checkInputValidity(inputField, val) {
      const currentValue = parseFloat(inputField.value);

      if(val > currentValue) {
        // alert('Jumlah tidak boleh kurang dari angka awal');
        return false
      }

      return true
      console.log(currentValue, val)
      // if(val)
    }

    $(document).on('input','.quantity-pesanan',debounce(function(){
     let id=$(this).data('id');
     let jumlah=parseInt($(this).val());

     if(jumlah<1){
        alert('Jumlah tidak boleh kurang dari 1');
        $(this).val(1);
        return;
     }
     if(jumlah>2000){
        alert('Jumlah tidak boleh melebihi 2000');
        $(this).val(2000);
        return;
     }

     $.post (`{{url('/pesanandetail')}}/${id}`,{
      '_token': $('[name=csrf-token]').attr('content'),
      '_method': 'put',
      'jumlah':jumlah
     })
     .done(response=>{
        loadform($('#diskon').val(), $('#diterima').val());
        table3.ajax.reload();
      })
      .fail(errors=>{
        alert('Tidak dapat menyimpan data');
        return;
      });
    },300));

    $(document).on('input','.quantity', debounce(function(){
     let id=$(this).data('id');
     let jumlah=($(this).val());
     let dataexist = $(this).attr('max');
     console.log(jumlah,dataexist,'asdnaks')


     if(jumlah<0.00){
        alert('Jumlah tidak boleh kurang dari 0.00');
        $(this).val(0.05);
        return;
     }
     if(jumlah>2000){
        alert('Jumlah tidak boleh melebihi 20000');
        $(this).val(2000);
        return;
     }

     $.post (`{{url('/orderbiliarddetail')}}/${id}`,{
      '_token': $('[name=csrf-token]').attr('content'),
      '_method': 'put',
      'jumlah':jumlah
     })
     .done(response=>{
        console.log(response, 'aksndaknd');
        loadform($('#diskon').val(), $('#diterima').val());
        table3.ajax.reload();
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

  function pilihpaket(id, nama, type){
    $('#id_paket_biliard').val(id);
    $('#nama_paket').val(nama);
    $('#seting_paket').val($('.seting').val());
    if(type == 'custom') {
        $('#modal-confirmation').modal('show');
    } else {
        hidepaket()
        tambahpaket()

        setTimeout(() => {
            storeOrder();
        }, 1500)
    }
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


  function tampilmenu(){
    let status=($('#status_pesanan').val());
    // if (status=="Aktif"){
      $('#modal-menu').modal('show');
    // }
    }

  function hidemenu(){
    $('#modal-menu').modal('hide');

  }

  function pilihmenu(id, nama){
    $('#id_menu').val(id);
    $('#nama_menu').val(nama);
    hidemenu()
    tambahmenu()
  }

  function tambahmenu(){
    $.post('{{route('pesanandetail.store')}}', $('.form-menu').serialize())
      .done(response=>{
        $('#nama_menu').focus();
        // table3.ajax.reload();
        location.reload();
      })
      .fail(errors=>{
        alert('Tidak dapat menyimpan data');
        return;
      });
  }

  function deleteData(url) {
    console.log("delete data");
    console.log(url);
    // harusnya tidak bisa dihapus, bisa dihapus ketika data menitnya lebih besar dari data awal
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    location.reload();
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
    var totalText = $('.total').text();
    var totalBil = $('.totalbil').text() || 0;
    let totalAll = parseInt(totalBil, 10);

    console.log(totalText, totalBil)

    $('#total').val($('.total').text());
    $('#total_jam').val($('.total_jam').text());
    $('#total_menit').val($('.total_menit').text());
    $('#total_flag').val($('.total_flag').text());
    $('#total_item').val($('.total_item').text());
    // $('#bayar').val(19999);
    $.get(`{{ url('/orderbiliarddetail/loadform') }}/${diskon}/${totalAll}/${diterima}`)
    .done(response => {
        let totals = parseInt(response.bayarrp) + parseInt(totalText, 10);

                $('#totalrp').val('Rp. '+ response.totalrp);
                $('#bayarrp').val('Rp. '+ response.bayarrp);
                $('#bayar').val(response.bayar);
                $('#diterima').val(response.bayar);
                $('#kembali').val(response.kembali);
                $('.tampil-bayar').text('Bayar: Rp. '+ totals.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                // $('.tampil-terbilang').text('Terbilang: '+response.terbilang);
                $('#kembalirp').val('Rp.'+ response.kembalirp);

                // if ($('#diterima').val() != 0) {
                //     $('.tampil-bayar').text('Kembali: Rp. '+ response.kembalirp);
                //     $('.tampil-terbilang').text(response.kembali_terbilang);
                // }
      })
    .fail(errors => {
                // alert('Tidak dapat menampilkan data');
                $('#diterima').trigger('input');
                return;
  })

  }


    function printNotaKitchen(id) {
        var urlcetak=(`{{url('orderbiliard')}}/cetak-kitchen/${id}`);
        console.log(id, 'askdansdk')
        cetak(urlcetak);
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
        if (newWindow) {
            setTimeout(() => {
                newWindow.close();
            }, 1000); // Wait for 2000 milliseconds (2 seconds)
        }
    }

    function storeDetail(id, nama){
      var setting_paket = $('#seting').val();
      $.ajax({
        type: 'POST',
        url: '{{route('orderbiliarddetail.store')}}',
        async:false,
        cache: false,
        data:{id_paket_biliard : id, nama : nama, setting_paket:setting_paket, id_order_biliard : {{$id_order_biliard}}, _token: '{{csrf_token()}}' },
        dataType: 'json',
        beforeSend: function() {

        },
        success: function(data) {
          storeOrder();
        },
        error: function() {
          console.log('gagal');
        }
      });
    }

    function storeOrder(){
      loadform();
      table.ajax.reload();
      console.log("storeOrder");
      setTimeout(() => {
        var form_process = $("#form_order");
        var data_form_process = $("#form_order").serializeArray();
        var m_data = new FormData();

        form_process.submit(function(e){
            e.preventDefault(e);
        });

        $.each(data_form_process, function(i, field){
            console.log(field)
            m_data.append(field.name, field.value);
        });

        m_data.append('_token', '{{csrf_token()}}');

        console.log(m_data);
        $.ajax({
            type: 'POST',
            url: "{{route('orderbiliard.store')}}",
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            type: 'POST',
            data: m_data,
            beforeSend: function() {

            },
            success: function(data) {
            console.log('Berhasil Order');
            },
            error: function() {
            console.log('gagal Order');
            }
        });
      }, 500)
    }

    function storePesanan(){
      var form_process				= $("#form_pesanan");
      var data_form_process 	= $("#form_pesanan").serializeArray();
      var m_data 						  = new FormData();

      form_process.submit(function(e){
        e.preventDefault(e);
      });

      $.each(data_form_process, function(i, field){
        m_data.append(field.name, field.value);
      });

      m_data.append('_token', '{{csrf_token()}}');
      $.ajax({
        type: 'POST',
        url: '{{route('pesanan.store')}}',
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'html',
        type: 'POST',
        data: m_data,
        beforeSend: function() {

        },
        success: function(data) {
          console.log('Berhasil Pesanan');
        },
        error: function() {
          console.log('gagal Pesanan');
        }
      });
    }

    function confirmDelete(url){
      $('#url_delete').val("");
      $('#confirm_delete').val("");
      $('#modal-delete').modal('show');
      $('#url_delete').val(url);
      //document.getElementById("url_delete");
    }

    function checkDelete(url){
      console.log("cek konfirm")
      console.log($('#url_delete').val());
      var password_input = $("#confirm_delete").val();
      var password_env   = '<?php echo env('PASS_KASIR');?>';
      var url            = $('#url_delete').val();
      if(password_env == password_input){
        deleteData(url)
      }else{
        alert('salah password')
      }

    }

    function confirmPassword(url){
      var password_input = $("#confirm_password").val();
      var password_env   = '<?php echo env('PASS_KASIR');?>';
      console.log(password_env, password_input)
      if(password_env == password_input){
        hidepaket()
        tambahpaket()
        $('#modal-confirmation').modal('hide');
        password_input = '';
        setTimeout(() => {
            storeOrder();
        }, 1500)
      } else {
          alert('salah password')
      }
    }

    function confirmDeleteMenu(url){
      $('#url_delete_menu').val("");
      $('#confirm_delete_menu').val("");
      $('#modal-delete_menu').modal('show');
      $('#url_delete_menu').val(url);
      //document.getElementById("url_delete");
    }

    function checkDeleteMenu(){
      console.log("cek konfirm")
      console.log($('#url_delete_menu').val());
      var password_input = $("#confirm_delete_menu").val();
      var password_env   = '<?php echo env('PASS_KASIR');?>';
      var url            = $('#url_delete_menu').val();
      if(password_env == password_input){
        deleteData(url)
      }else{
        alert('Password Delete salah')
      }
    }
</script>
@endpush

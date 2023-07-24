@extends('HalamanAwal.master')

@section('title')
    Order Cafe
@endsection

@push('css')
<style>
.form-order, .btn-hapus, .btn-stop, .btn-simpan, .btn-cetak, .btn-tambah,.btn-pindah,.btn-cetakselesai{
    font-size:12pt;
  }
  .table-pesanan tbody tr:last-child {
        display:none;
    }
  .table-pesanan tbody tr:nth-child(even) {
  background-color: #cef0b1;
    } 
  .table-pesanan  thead{background-color: #96bf73;}
  table{font-size: 12pt;}
  input[type="text"]{font-size:12pt;}
  input[type="number"]{font-size:12pt;}

  .table-menu tbody tr:nth-child(even) {
  background-color: #cef0b1;
    } 
  .table-menu  thead{background-color: #96bf73;}

  .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }
  .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }
  .table-pesanan tbody tr:last-child {
        display:none;
    }  
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
    <li class="active">TransaksiPembelian</li>
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
                  <td>Nomor Meja:</td>
                  <td>{{$meja->nama_meja}}</td>
                </tr>
                <tr>
                  <td>No.Pesanan:</td>
                  <td>{{$Id_pesanan}}</td>
                </tr>
              </table>         
            </div>
            <div class="box-body">
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
                    <label for="nama_cust" class="col-lg-1">Customer</label>
                    <div class="col-lg-3">
                      <input type="text" class="form-control" name="nama_cust" id="nama_cust" maxlength="50" value="{{$pesanan->customer}}" required> 
                      <span class="help-block with-errors"></span>
                    </div>
                    <div class="input-group-btn">
                          <button onclick="tampilmenu()" class="btn btn-info btn-flat btn-tambah" type="button"><i class="fa fa-plus-circle"></i> Tambah Menu</button>
                    </div>
                    </div>            
                </form>

              <table class="table table-stiped table-bordered table-pesanan">
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
                        <form action="{{ route('pesanan.store') }}" class="form-pesanan" method="post">
                            @csrf
                            <input type="hidden" name="id_meja_cafe" id="id_meja_cafe" value="{{ $meja->id_meja }}">
                            <input type="hidden" name="status_meja" id="status_meja" value="{{ $meja->Status }}">
                            <input type="hidden" name="status_pesanan" id="status_pesanan" value="{{ $pesanan->status }}">
                            <input type="hidden" name="nama_cust2" id="nama_cust2" value="{{$pesanan->customer}}">
                            <input type="hidden" name="id_pesanan" value="{{ $Id_pesanan }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">
                            <input type="hidden" name="kembali" id="kembali">
                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control" value="{{ $pesanan->Diskon }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diterima" id="diterima" class="form-control" value="{{ $pesanan->Diterima }}">
                               </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembalirp" class="col-lg-2 control-label">Kembali</label>
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
                <button type="submit" class="btn btn-warning btn-sm btn-flat pull-right btn-cetak "><i class="fa fa-floppy-o"></i> Cetak Transaksi</button>
                <!--button type="submit" class="btn btn-danger btn-sm btn-flat pull-right btn-cetakselesai "><i class="fa fa-check"></i> Cetak & Selesai</button-->
            </div>
        </div>
    </div>
</div>

@includeIf('pesanandetail.menu')

@endsection

@push('scripts')
<script>
  let table, table2;

  $(function(){
   table= $('.table-pesanan').DataTable({
     responsive:true,
     processing: true,
     serverSide: true,
     autoWidth:false,
     ajax: {
        url: '{{route('pesanandetail.data', [$Id_pesanan, $pesanan->status])}}',
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

   table2= $('.table-menu').DataTable();

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

   $(document).on('input','.quantity',debounce(function(){
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
        table.ajax.reload();       
      })
      .fail(errors=>{
        alert('Tidak dapat menyimpan data');
        return;
      });
    },300));

  $(document).on('input', '#diskon',  debounce(function() {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }
            loadform($(this).val(), $('#diterima').val());
        },300));
  
  $('#diterima').on('input', debounce(function () {
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
      $('.form-pesanan').submit();
        });

  $('.btn-cetak').on('click', function () {
      $('.form-pesanan').submit();
      cetak('{{ route('pesanan.cetak', $Id_pesanan) }}', 'Nota');  
        });
  $('.btn-cetakselesai').on('click', function () {
      $('.form-pesanan').submit();
      $.get('{{route('meja.reset', $meja->id_meja)}}'); 
      cetak('{{ route('pesanan.cetak', $Id_pesanan) }}', 'Nota'); 
      
        });     
});
    
  
  function tampilmenu(){
    let status=($('#status_pesanan').val());
    if (status=="Aktif"){
      $('#modal-menu').modal('show');
    }
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
        table.ajax.reload();
      })
      .fail(errors=>{
        alert('Tidak dapat menyimpan data');
        return;
      });
  }

  function deleteData(url) {
    let status=($('#status_pesanan').val());
    if (status=="Aktif"){
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
    }

  function loadform(diskon = 0, diterima = 0){
    $('#total').val($('.total').text());
    $('#total_item').val($('.total_item').text());
    $.get(`{{ url('/pesanandetail/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
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
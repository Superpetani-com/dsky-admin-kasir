<style>
    .btn-Selesai {
        display: none;
    }

    .btn-Diproses {
        display: none;
    }
</style>

<div class="modal fade" id="modal-form2" tabindex="-1" role="dialog" aria-labelledby="modal-form2">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buat Order Baru</h4>
      </div>
      <div class="modal-body">
      <table class="table table-order table-striped table-bordered">
          <thead>
            <th width=5%>No.</th>
            <th>Meja</th>
            <th width=20%>Keterangan</th>
            <th width=15%><i class="fa fa-cog"></i></th>
            <th width=15%>Reset?</th>
          </thead>
            @foreach ($meja as $key=>$item)
            <tr >
              <td width=5%>{{$key+1}}</td>
              <td>{{$item->nama_meja}}
              @if ($item->pesanan)
                {{$item->pesanan['customer']}}
              @endif
              </td>
              <td width=20%><div  class="{{$item->Status}}">{{$item->Status}}</div></td>
              <td width=15%>
                <a href="{{route ('pesanan.create', $item->id_meja)}}" class="btn btn-primary btn-sm btn-flat btn-{{$item->Status}}">
                  <i class="fa fa-check-circle"></i>  Pilih
                </a>
              </td>
              <td width=15%>
              <button type="button" onclick="resetform1('{{route('meja.reset', $item->id_meja)}}', '{{$item->Id_pesanan}}')" class="btn btn-xs btn-danger btn-flat btnr-{{$item->Status}}"><i class="fa fa-book"> </i> Selesai</button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

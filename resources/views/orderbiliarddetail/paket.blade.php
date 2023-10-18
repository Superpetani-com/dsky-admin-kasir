<div class="modal fade" id="modal-paket" tabindex="-1" role="dialog" aria-labelledby="modal-paket">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pilih Paket</h4>
      </div>

      <div class="modal-body">

        <table class="table table-striped table-bordered table-paket">
          <thead>
            <th width="5%">No.</th>
            <th>Paket</th>
            <th>Harga</th>
            <th>Keterangan</th>
            <th><i class="fa fa-cog"></i></th>
          </thead>
          <tbody>
            @foreach ($paket as $key=>$item)
            <tr>
              <td width="5%">{{$key+1}}</td>
              <td>{{$item->nama_paket}}</td>
              <td>{{$item->harga}}</td>
              <td>{{$item->keterangan}}</td>
              <td>
                <button href="#" class="btn btn-primary btn-xs btn-flat"
                  onclick="pilihpaket('{{$item->id_paket_biliard}}','{{$item->nama_paket}}')">
                  <i class="fa fa-check-circle"></i>  Pilih
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        <div class="form-group">
          <label>Seting Waktu</label>
          <select class="form-control seting" id="seting">
          <option>AUTO</option>
          <option>MANUAL</option>
          </select>
        </div>

      </div>
    </div>
  </div>
</div>

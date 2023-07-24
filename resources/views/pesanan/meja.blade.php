<div class="modal fade" id="modal-meja" tabindex="-1" role="dialog" aria-labelledby="modal-menu">
  <div class="modal-dialog" role="document">
      
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pilih Meja</h4>
      </div>
      <div class="modal-body">
        <table class="table table-pesananbaru table-striped table-bordered">
          <thead>
            <th>No.</th>
            <th>Meja</th>
            <th><i class="fa fa-cog"></i></th>
          </thead>
          <tbody>
            @foreach ($meja as $key=>$item)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$item->nama_meja}}</td>
              <td>
                <a href="{{route ('pesanan.create', $item->id_meja)}}" class="btn btn-primary btn-xs btn-flat">
                  <i class="fa fa-check-circle"></i>  Pilih
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
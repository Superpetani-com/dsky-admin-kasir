<div class="modal fade" id="modal-menu" tabindex="-1" role="dialog" aria-labelledby="modal-menu">
  <div class="modal-dialog" role="document">
      
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pilih Menu</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered table-menu">
          <thead>
            <th width="5%">No.</th>
            <th>Menu</th>
            <th>Harga</th>
            <th>Stok</th>
            <th><i class="fa fa-cog"></i></th>
          </thead>
          <tbody>
            @foreach ($menu as $key=>$item)
            <tr>
              <td width="5%">{{$key+1}}</td>
              <td>{{$item->Nama_menu}}</td>
              <td>{{$item->Harga}}</td>
              <td>{{$item->stok}}</td>
              <td>
                <button href="#" class="btn btn-primary btn-xs btn-flat"
                  onclick="pilihmenu('{{$item->Id_Menu}}','{{$item->Nama_menu}}')">
                  <i class="fa fa-check-circle"></i>  Pilih
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
</div>
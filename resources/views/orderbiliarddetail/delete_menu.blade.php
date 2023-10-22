<div class="modal fade" id="modal-delete_menu" tabindex="-1" role="dialog" aria-labelledby="modal-delete_menu">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pilih Paket</h4>
      </div>

      <div class="modal-body">
        <h4 class="modal-title">Apakah Anda yakin Menghapus paket?</h4>
        <div class="form-group row">
            <div class="col-md-12">
                <input type="password" name="confirm_delete_menu" id="confirm_delete_menu" class="form-control" required autofocus>
                <input type="hidden" name="url_delete_menu" id="url_delete_menu" class="form-control" >
                <span class="help-block with-errors"></span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick ="checkDeleteMenu()">Konfirmasi</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

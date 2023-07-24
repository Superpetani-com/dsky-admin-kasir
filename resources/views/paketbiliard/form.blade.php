<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
  <div class="modal-dialog" role="document">
      <form action="" method="post" class="form-horizontal">
          @csrf
          @method('post')
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Menu</h4>
      </div>
      <div class="modal-body">
            <div class="form-group row">
                <label for="nama_paket" class="col-md-3 control-label">Nama Paket</label>
                <div class="col-md-7">
                    <input type="text" name="nama_paket" id="nama_paket" class="form-control" required autofocus>
                    <span class="help-block with-errors"></span>
                </div>
                </div>
                <div class="form-group row">
                <label for="harga" class="col-md-3 control-label">Harga</label>
                <div class="col-md-7">
                    <input type="number" name="harga" id="harga" class="form-control" required>
                    <span class="help-block with-errors"></span>
                </div>
                </div>
                <div class="form-group row">
                <label for="durasi" class="col-md-3 control-label">Durasi(Menit)</label>
                <div class="col-md-7">
                    <input type="number" name="durasi" id="durasi" class="form-control" required>
                    <span class="help-block with-errors"></span>
                </div>
                </div>
                <div class="form-group row">
                <label for="keterangan" class="col-md-3 control-label">Keterangan</label>
                <div class="col-md-7">
                    <textarea type="text" name="keterangan" id="keterangan" class="form-control" rows="2" maxlength="200" required></textarea>
                    <span class="help-block with-errors"></span>
                </div>
                </div>
                
        </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
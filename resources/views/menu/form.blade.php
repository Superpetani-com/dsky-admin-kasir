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
                <label for="nama_menu" class="col-md-2 col-md-offset-1 control-label">Menu</label>
                <div class="col-md-9">
                    <input type="text" name="nama_menu" id="nama_menu" class="form-control" required autofocus>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
                <div class="form-group row">
                <label for="harga" class="col-md-2 col-md-offset-1 control-label">Harga</label>
                <div class="col-md-9">
                    <input type="number" name="harga" id="harga" class="form-control" required>
                    <span class="help-block with-errors"></span>
                </div>
                </div>
                <div class="form-group row">
                <label for="stok" class="col-md-2 col-md-offset-1 control-label">Stok</label>
                <div class="col-md-9">
                    <input type="number" name="stok" id="stok" class="form-control" required>
                    <span class="help-block with-errors"></span>
                </div>
                </div>
                
                    
                    
                <div class="form-group row">
                  <label for="jeni" class="col-md-2 col-md-offset-1 control-label">Seting</label>
                  <div class="col-md-9">
                  <select class="form-control jenis" name="jenis" id="jenis">
                  <option>Tidak Update Stok</option>
                  <option>Update Stok</option>
                  </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="kategori" class="col-md-2 col-md-offset-1 control-label">Kategori</label>
                  <div class="col-md-9">
                  <select class="form-control kategori" name="kategori" id="kategori">
                  <option>Makanan</option>
                  <option>Minuman</option>
                  </select>
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
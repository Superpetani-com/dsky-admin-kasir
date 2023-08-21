<div class="modal fade" id="modal-form-user" tabindex="-1" role="dialog" aria-labelledby="modal-form-user">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('user.register') }}" method="get" data-toggle="validator" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Periode Laporan</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-3 control-label">Nama Lengkap</label>
                        <div class="col-md-7">
                            <input autocomplete="off" type="text" name="name" id="name" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-3 control-label">Email</label>
                        <div class="col-md-7">
                            <input autocomplete="off" type="email" name="email" id="email" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-md-3 control-label">Role</label>
                        <div class="col-md-7">
                            <select name="level" id="role" class="form-control row">
                              <option value="1">Kasir</option>
                              <option value="2">Admin</option>
                              <option value="3">Superadmin</option>
                              <option value="4">Manager</option>
                              <option value="5">Kitchen</option>
                              <option value="6">Waiters</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-3 control-label">Password</label>
                        <div class="col-md-7">
                            <input autocomplete="off"  type="password" name="password" id="password" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <input type="hidden" name="cabang_id" value="Jogja Billiard">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

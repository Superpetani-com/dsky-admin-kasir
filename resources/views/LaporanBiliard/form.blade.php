<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('laporan.indexbiliard') }}" method="get" data-toggle="validator" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Periode Laporan</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tanggal_awal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Awal</label>
                        <div class="col-lg-6">
                            <input type="datetime-local" name="tanggal_awal" id="datetimepicker" class="form-control" required autofocus
                                value="{{ request('tanggal_awal') }}"
                                style="border-radius: 0 !important;"
                                autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_akhir" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Akhir</label>
                        <div class="col-lg-6">
                            <input type="datetime-local" name="tanggal_akhir" id="datetimepicker" class="form-control" required
                                value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}"
                                style="border-radius: 0 !important;"
                                autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr('#datetimepicker', {
        enableTime: true, // Enable time selection
        dateFormat: "Y-m-d H:i", // Format of the input value
    });
</script>

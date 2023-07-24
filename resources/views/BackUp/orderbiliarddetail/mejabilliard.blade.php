<div class="modal fade" id="modal-form1" tabindex="-1" role="dialog" aria-labelledby="modal-form1">
  <div class="modal-dialog" role="document">
      <form action="" method="post" class="form-horizontal">
          @csrf
          @method('post')
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pindah Meja Biliard</h4>
      </div>
      <div class="modal-body">
            
      <table class="table table-mejabiliard table-striped table-bordered">
          <thead>
            <th width=5%>No.</th>
            <th>Meja</th>
            <th width=20%>Keterangan</th>
            <th width=15%><i class="fa fa-cog"></i></th>
          </thead>
          <tbody>
            @foreach ($mejadetail as $key=>$item)
            <tr >
              <td width=5%>{{$key+1}}</td>
              <td>{{$item->namameja}}</td>
              <td width=20%><div  class="{{$item->status}}">{{$item->status}}</div></td>
              <td width=15%>
                <a href="{{route ('mejabiliard.pindah', [$item->id_meja_biliard, $mejabiliard->id_meja_biliard,$id_order_biliard] )}}" class="btn btn-primary btn-sm btn-flat btn-{{$item->status}}">
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
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
  <div class="modal-dialog" role="document">
      <form action="" method="post" class="form-horizontal">
          @csrf
          @method('post')
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buat Order Biliard Baru</h4>
      </div>
      <div class="modal-body">
            
      <table class="table table-orderbiliard table-striped table-bordered">
          <thead>
            <th width=5%>No.</th>
            <th>Meja</th>
            <th width=20%>Keterangan</th>
            <th width=15%><i class="fa fa-cog"></i></th>
          </thead>
          <tbody>
            @foreach ($mejabiliard as $key=>$item)
            <tr >
              <td width=5%>{{$key+1}}</td>
              <td>{{$item->namameja}}</td>
              <td width=20%><div  class="{{$item->status}}">{{$item->status}}</div></td>
              <td width=15%>
                <a href="{{route ('orderbiliard.create', $item->id_meja_biliard)}}" class="btn btn-primary btn-sm btn-flat btn-{{$item->status}}">
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
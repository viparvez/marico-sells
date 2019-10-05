<div class="alert alert-danger print-error-msg" style="display:none">
    <ul></ul>
</div>

<form role="form" action="{{route('districts.update', $district->id)}}" id="update" method="POST">
  <div class="card-body">

    {{csrf_field()}}
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
      <label for="districtName">District Name</label>
      <input type="text" class="form-control" id="districtName" name="name" placeholder="Enter Name" value="{{$district->name}}">
    </div>

  </div>
  <!-- /.card-body -->

  <div class="card-footer">
    <span class='btn btn-block btn-success btn-sm' id='submitEdit' onclick="update()">SAVE</span>
    <span class='btn btn-block btn-success btn-sm' id='loadingEdit' style='display: none' disabled=''>Working...</span>
  </div>
</form>
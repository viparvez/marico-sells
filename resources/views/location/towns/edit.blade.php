<div class="alert alert-danger print-error-msg" style="display:none">
    <ul></ul>
</div>

<form role="form" action="{{route('towns.update', $town->id)}}" id="update" method="POST">
  <div class="card-body">

    {{csrf_field()}}
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
      <label for="districtName">Town Name</label><code>*</code>
      <input type="text" class="form-control" id="districtName" name="name" placeholder="Enter Name" value="{{$town->name}}">
    </div>

    <div>
      <label>District</label><code>*</code>
      <select class="form-control" name="district_id">
        <option value="{{$town->District->id}}" selected>{{$town->District->name}}</option>
        @foreach($districts as $k=>$v)
          <option value="{{$v->id}}">{{$v->name}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Activate/Deactivate</label><code>*</code>
      <select name="active" class="form-control">
        <option value="1" @if($town->active == '1') selected @else @endif>Active</option>
        <option value="0" @if($town->active == '0') selected @else @endif>Deactive</option>
      </select>
    </div>

  </div>
  <!-- /.card-body -->

  <div class="card-footer">
    <span class='btn btn-block btn-success btn-sm' id='submitEdit' onclick="update()">SAVE</span>
    <span class='btn btn-block btn-success btn-sm' id='loadingEdit' style='display: none' disabled=''>Working...</span>
  </div>
</form>
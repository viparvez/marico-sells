<div class="alert alert-danger print-error-msg" style="display:none">
    <ul></ul>
</div>

<form role="form" action="{{route('recepients.update', $rec->id)}}" id="update" method="POST">
  <div class="card-body">

    <input type="hidden" name="template_id" value="{{$templates->id}}">
    {{csrf_field()}}
    <div class="form-group">
      <label for="address">Email Address</label><code>*</code>
      <input type="email" class="form-control" id="address" name="address" placeholder="Enter Email" value="{{$rec->address}}">
    </div>


    <div class="form-group">
      <label>Type</label><code>*</code><br>
      <select name="rectype" class="form-control">
        <option value="PRIMARY" @if($rec->rectype == 'PRIMARY') selected @else @endif>PRIMARY</option>
        <option value="CC" @if($rec->rectype == 'CC') selected @else @endif>CC</option>
      </select>
    </div>

  </div>
  <!-- /.card-body -->

  <div class="card-footer">
    <span class='btn btn-block btn-success btn-sm' id='submitEdit' onclick="update()">SAVE</span>
    <span class='btn btn-block btn-success btn-sm' id='loadingEdit' style='display: none' disabled=''>Working...</span>
  </div>
</form>
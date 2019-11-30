<div class="alert alert-danger print-error-msg" style="display:none">
    <ul></ul>
</div>

<form role="form" action="{{route('users.mychangepass')}}" id="update" method="POST">
  <div class="card-body">

    {{csrf_field()}}
    <input type="hidden" name="_method" value="PUT">

    <div class="col-12 row">
      <div class="col-4">

        <div class="form-group">
          <label for="">Old Password:</label><code>*</code>
          <input type="password" class="form-control" id="" name="old_password" placeholder="Password">
        </div>

      </div>

      <div class="col-4">
        <div class="form-group">
          <label for="">Password:</label><code>*</code>
          <label for="">Confirm Password:</label><code>*</code>
          <input type="password" class="form-control" id="" name="password" placeholder="New Password">
        </div> 
      </div>  

      <div class="col-4">
        <div class="form-group">
          <label for="">Confirm Password:</label><code>*</code>
          <input type="password" class="form-control" id="" name="password_confirmation" placeholder="Confirm Password">
        </div> 
      </div>  

    </div>

  </div>
  <!-- /.card-body -->

  <div class="card-footer">
    <span class='btn btn-block btn-success btn-sm' id='submitEdit' onclick="update()">SAVE</span>
    <span class='btn btn-block btn-success btn-sm' id='loadingEdit' style='display: none' disabled=''>Working...</span>
  </div>
</form>
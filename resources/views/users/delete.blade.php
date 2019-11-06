<div class="alert alert-danger print-error-msg" style="display:none">
    <ul></ul>
</div>

<form role="form" action="{{route('users.update', $user->id)}}" id="update" method="POST">
  <div class="card-body">

    {{csrf_field()}}
    <input type="hidden" name="_method" value="PUT">

    <div class="col-12 row">
      <div class="col-6">
        <div class="form-group">
          <label for="">Full Name</label><code>*</code>
          <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="{{$user->name}}">
        </div>

        <div class="form-group">
          <label for="">Username</label><code>*</code>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{$user->username}}">
        </div>

        <div class="form-group">
          <label for="">Email</label><code>*</code>
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email}}">
        </div>

      </div>

      <div class="col-6">

        <div class="form-group">
          <label for="">Gender</label><code>*</code>
          <select name="gender" class="form-control">
            <option value="Male" @if($user->gender == 'Male') selected @else @endif>Male</option>
            <option value="Female" @if($user->gender == 'Female') selected @else @endif>Female</option>
          </select>
        </div>

        <div class="form-group">
          <label for="">Role</label><code>*</code>
          <select name="role" class="form-control">
            <option value="Agent" @if($user->role == 'Agent') selected @else @endif>Agent</option>
            <option value="Admin" @if($user->role == 'Admin') selected @else @endif>Admin</option>
          </select>
        </div>

        <div class="form-group">
          <label for="">Active</label><code>*</code>
          <select name="active" class="form-control">
            <option value="1" @if($user->active == '1') selected @else @endif>YES</option>
            <option value="0" @if($user->active == '0') selected @else @endif>NO</option>
          </select>
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
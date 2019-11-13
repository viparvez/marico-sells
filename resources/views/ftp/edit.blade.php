
@extends('layouts.app')
@section('content')

<style type="text/css">
  .error {
    color: red;
  }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br>
    <section class="content">
      <div class="row">

        <div class="col-12">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item">Communications</li>
            <li class="breadcrumb-item active">FTP Settings</li>
          </ol>
        </div>

        <div class="row col-12" style="background: white; padding-left: 10%; padding-top: 20px; padding-bottom: 20px; padding-right: 10%">
          @if(Session::has('success'))
          <p class="alert btn-block btn-success">{{ Session::get('success') }}</p>
          @elseif(Session::has('error'))
          <p class="alert btn-block btn-danger">{{ Session::get('error') }}</p>
          @endif

          <div class="col-6">
            <form class="form" method="POST" action="{{route('ftp.update', $ftp->id)}}">
            {{csrf_field()}}

            <input type="hidden" name="_method" value="PUT">

            <div class="form-group">
              <label for="">Server Address</label><code>(*)</code>
              <input type="text" class="form-control" name="server_name" placeholder="Server Address" value="{{$ftp->server}}">
              @if ($errors->has('server_name'))
                  <div class="error">{{ $errors->first('server_name') }}</div>
              @endif
            </div>

            <div class="form-group">
              <label for="">Username</label><code>(*)</code>
              <input type="text" class="form-control" name="username" placeholder="Username" value="{{$ftp->username}}">
              @if ($errors->has('email'))
                  <div class="username">{{ $errors->first('username') }}</div>
              @endif
            </div>

            <div class="form-group">
              <label for="">Password</label><code>(*)</code>
              <input type="password" class="form-control" name="password" placeholder="" value="{{$ftp->password}}">
              @if ($errors->has('password'))
                  <div class="error">{{ $errors->first('password') }}</div>
              @endif
            </div>

            <div class="form-group">
              <label for="">Port Number</label><code>(*)</code>
              <input type="text" class="form-control" name="port_number" placeholder="Please provide Port Numbner" value="{{$ftp->port}}">
              @if ($errors->has('port_number'))
                  <div class="error">{{ $errors->first('port_number') }}</div>
              @endif
            </div>

            <button type="submit" class="btn btn-success">UPDATE</button>
            </form>

          </div>
        
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal'>&times;</button>
          </div>
          <div class='alert alert-danger print-error-msg' id='error_messages' style='display:none'>
            <ul></ul>
          </div>
          <div class="text-center">
            <img src="{{url('/')}}/public/img/spinner.gif" id="spinner">
          </div>

          <div id="showcontent">
            
          </div>
        </div>
      </div>
    </div>
@endsection

@section('footer-resource')
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>

<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>

<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>


<script src="{{asset('js/marico.js')}}"></script>

<!-- Page script -->
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>

</body>
</html>

@endsection


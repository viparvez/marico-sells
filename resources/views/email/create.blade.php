
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
            <li class="breadcrumb-item active">System Email Setting</li>
          </ol>
        </div>

        <div class="row col-12" style="background: white; padding-left: 10%; padding-top: 20px; padding-bottom: 20px">
          @if(Session::has('success'))
          <p class="alert btn-block btn-success">{{ Session::get('success') }}</p>
          @elseif(Session::has('error'))
          <p class="alert btn-block btn-danger">{{ Session::get('error') }}</p>
          @endif
        <form class="form" method="POST" action="{{route('email.store')}}">

          <div class="col-2">
            
          </div>

          <div class="col-8">

            {{csrf_field()}}

            <div class="form-group">
              <label for="districtName">Email Address</label><code>(*)</code>
              <input type="text" class="form-control" name="email" placeholder="example@example.com">
              @if ($errors->has('email'))
                  <div class="error">{{ $errors->first('email') }}</div>
              @endif
            </div>

            <div class="form-group">
              <label for="districtName">Password</label><code>(*)</code>
              <input type="password" class="form-control" name="password" placeholder="">
              @if ($errors->has('password'))
                  <div class="error">{{ $errors->first('password') }}</div>
              @endif
            </div>

            <div class="form-group">
              <label for="districtName">Email ALIAS</label><code>(*)</code>
              <input type="text" class="form-control" name="alias" placeholder="SuperTel Limited">
              @if ($errors->has('alias'))
                  <div class="error">{{ $errors->first('alias') }}</div>
              @endif
            </div>

            <div class="form-group">
              <label for="districtName">Outgoing Server</label><code>(*)</code>
              <input type="text" class="form-control" name="outgoing_server" placeholder="smtp.gmail.com">
              @if ($errors->has('outgoing_server'))
                  <div class="error">{{ $errors->first('outgoing_server') }}</div>
              @endif
            </div>

            <div class="form-group">
              <label for="">Outgoing Protocol</label><code>(*)</code>
              <select class="form-control" name="outgoing_protocol">
                <option value="ssl">SMTPS</option>
                <option value="tls">TLS</option>
              </select>

              @if ($errors->has('outgoing_protocol'))
                  <div class="error">{{ $errors->first('outgoing_protocol') }}</div>
              @endif
            </div>

            <div class="form-group">
              <label for="districtName">Outgoing Port</label><code>(*)</code>
              <input type="text" class="form-control" name="outgoing_port" placeholder="465">
              @if ($errors->has('outgoing_port'))
                  <div class="error">{{ $errors->first('outgoing_port') }}</div>
              @endif
            </div>

            <div class="">
              <label>For Gsuit email addresses, please check that access for Less Secured Apps is <code>Turned On</code></label>
              <button type="submit" class='btn btn-block btn-success btn-sm' type='submit'>SAVE</button>
            </div>

          </div>

        </form>
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


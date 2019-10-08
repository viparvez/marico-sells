@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br>
    <section class="content">
      <div class="row">

        <div class="col-10">
          <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item">Product Management</li>
            <li class="breadcrumb-item active">Products</li>
          </ol>
        </div>
        <div class="col-2">
          <button class="btn btn-block btn-success btn-flat" data-toggle="modal" data-target="#myModal">NEW</button> <br>
        </div> 

        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-striped">
                <thead>
                <tr>
                  <th>#SL</th>
                  <th>Shop Name</th>
                  <th>Retailer Code</th>
                  <th>Town</th>
                  <th>RMN</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($retailers as $k => $v)
                  <tr>
                    <td>{{$k+1}}</td>
                    <td>{{$v->shopname}}</td>
                    <td>{{$v->code}}</td>
                    <td>{{$v->Town->name}}</td>
                    <td>{{$v->rmn}}</td>
                    <td>{{$v->email}}</td>
                    <td>
                      @if($v->active == '1')
                        <span class="btn btn-xs btn-success">ACTIVE</span>
                      @else
                        <span class="btn btn-xs btn-danger">INACTIVE</span>
                      @endif
                    </td>
                    <td>
                      <a class="btn btn-xs btn-success" onclick="show('{{route('retailers.show',$v->id)}}')"><span style="color: white">VIEW</span></a>
                    </td>
                  </tr>
                @endforeach
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add New Retailer</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="alert alert-danger print-error-msg" style="display:none">
          <ul></ul>
      </div>

      <form role="form" action="{{route('retailers.store')}}" id="create" method="POST">
        <div class="card-body">
          {{csrf_field()}}
          
          <div class="row col-12">
            <div class="col-6">
              <div class="form-group">
                <label for="">Shop Name</label>
                <input type="text" class="form-control" id="shopname" name="shopname" placeholder="Enter Shop Name">
              </div>

              <div class="form-group">
                <label for="">Retailer Code</label>
                <input type="text" class="form-control" id="code" name="code" placeholder="Enter Retailer Code">
              </div>

              <div class="form-group">
                <label for="">Town</label>
                <select name="town_id" class="form-control">
                  <option value="">Select</option>
                  @foreach($towns as $k => $v)
                    <option value="{{$v->id}}">{{$v->name}}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="">Owner Name</label>
                <input type="text" class="form-control" id="ownername" name="ownername" placeholder="Owner Name">
              </div>

              <div class="form-group">
                <label for="">Registered Mobile Number (RMN)</label>
                <input type="text" name="rmn" class="form-control" placeholder="01890100100">
              </div>
            </div>


            <div class="col-6">
              <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="example@example.com">
              </div>

              <div class="form-group">
                <label for="">HQ</label>
                <input type="text" class="form-control" id="hq" name="hq" placeholder="">
              </div>

              <div class="form-group">
                <label for="">DSH</label>
                <input type="text" class="form-control" id="dsh" name="dsh" placeholder="">
              </div>

              <div class="form-group">
                <label for="">RH</label>
                <input type="text" class="form-control" id="rh" name="rh" placeholder="">
              </div>

              <div class="form-group">
                <label for="">Scheme</label>
                <input type="text" class="form-control" id="scheme" name="scheme" placeholder="">
              </div>
            </div>
          </div>       

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button class='btn btn-block btn-success btn-sm' id='submit' type='submit'>SAVE</button>
          <button class='btn btn-block btn-success btn-sm' id='loading' style='display: none' disabled=''>Working...</button>
        </div>
      </form>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


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




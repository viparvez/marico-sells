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
            <li class="breadcrumb-item">Sales</li>
            <li class="breadcrumb-item active">List</li>
          </ol>
        </div>

        <div class="col-12">
          <div class="card">
            
            <form class="form row" action="{{route('sales.search')}}" method="POST" style="padding-top: 10px">
              {{csrf_field()}}
              
              <div class="col-1"></div>

              <div class="col-4">
                <label>From</label>
                <input class="form-control" type="date" name="from"f>

              </div>

              <div class="col-4">
                <label>To</label>
                <input class="form-control" type="date" name="to">
              </div>

              <div class="col-2">
                <br>
                <input type="submit" name="search" class="btn btn-success" value="SEARCH">
              </div>

            </form>


            <!-- /.card-header -->
            <div class="card-body">
              <table id="" class="table table-striped">
                <thead>
                <tr>
                  <th>#SL</th>
                  <th>Order Code</th>
                  <th>Retailer</th>
                  <th>Retailer Code</th>
                  <th>Order Date</th>
                  <th>Made By</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $k => $v)
                  <tr>
                    <td>{{$k+1}}</td>
                    <td>{{$v->code}}</td>
                    <td>{{$v->Retailer->shopname}}</td>
                    <td>{{$v->Retailer->code}}</td>
                    <td>{{$v->created_at}}</td>
                    <td>{{$v->CreatedBy->name}}</td>
                    <td>
                      <a class="btn btn-xs btn-success" onclick="show('{{route('sales.show',$v->id)}}')"><span style="color: white">VIEW</span></a>
                    </td>
                  </tr>
                @endforeach
              </table>
              <span style="float: right;">{{$orders->render()}}</span>
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


<div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
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




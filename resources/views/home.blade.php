@extends('layouts.app')


@section('content')
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <a href="#">Today's Last 5 Sales</a>
              </div>

              <div class="card-body">
                <table class="table table-striped">
                  <thead>
                    <th>Time</th>
                    <th>Sales Code</th>
                    <th>User/Agent</th>
                    <th>Retailer Name</th>
                    <th>Retailer Code</th>
                  </thead>

                  <tbody>
                    @foreach($last_calls as $k=>$v)
                    <tr>
                      <td>{{date('h:i:s A', strtotime($v->created_at))}}</td>
                      <td>
                        <a href="#" onclick="show('{{route('sales.show',$v->id)}}')">{{$v->code}}</a>
                      </td>
                      <td>{{$v->CreatedBy->name}}</td>
                      <td>{{$v->Retailer->shopname}}</td>
                      <td>{{$v->Retailer->code}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <a href="#">Monthly Top Sale (Product Wise)</a>
              </div>

              <div class="card-body">
                <div id="chartdiv"></div>
              </div>
            </div>
          </div>

        </div>
      
      </div>
    </div>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

    
@endsection

<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script type="text/javascript" src="{{asset('dist/js/barchart.js')}}"></script>

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

<script src="{{asset('dist/js/demo.js')}}"></script>

<script src="{{asset('js/marico.js')}}"></script>

@if (!empty($result))

@if(count($result) < 10)

<script type="text/javascript">

  var data = [{
  "country": "{{$result[0]->name}}",
  "visits": {{$result[0]->total}}
}, {
  "country": "{{$result[1]->name}}",
  "visits": {{$result[1]->total}}
},{
  "country": "{{$result[2]->name}}",
  "visits": {{$result[2]->total}}
}, {
  "country": "{{$result[3]->name}}",
  "visits": {{$result[3]->total}}
}, {
  "country": "{{$result[4]->name}}",
  "visits": {{$result[4]->total}}
}];


</script>

@else

<script type="text/javascript">

  var data = [{
  "country": "{{$result[0]->name}}",
  "visits": {{$result[0]->total}}
}, {
  "country": "{{$result[1]->name}}",
  "visits": {{$result[1]->total}}
},{
  "country": "{{$result[2]->name}}",
  "visits": {{$result[2]->total}}
}, {
  "country": "{{$result[3]->name}}",
  "visits": {{$result[3]->total}}
}, {
  "country": "{{$result[4]->name}}",
  "visits": {{$result[4]->total}}
}, {
  "country": "{{$result[5]->name}}",
  "visits": {{$result[5]->total}}
}, {
  "country": "{{$result[6]->name}}",
  "visits": {{$result[6]->total}}
}, {
  "country": "{{$result[7]->name}}",
  "visits": {{$result[7]->total}}
}, {
  "country": "{{$result[8]->name}}",
  "visits": {{$result[8]->total}}
}, {
  "country": "{{$result[9]->name}}",
  "visits": {{$result[9]->total}}
}];


</script>

@endif

@else
@endif

</body>
</html>

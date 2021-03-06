

@extends('layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <br>

    <section class="content">

      <div class="row">



        <div class="col-12 row">



          @if(Session::has('success'))

          <p class="alert btn-block btn-success">{{ Session::get('success') }}</p>

          @elseif(Session::has('error'))

          <p class="alert btn-block btn-danger">{{ Session::get('error') }}</p>

          @endif



          <div class="col-4">

            <div class="card card-primary">

              <div class="card-header">

                <h3 class="card-title">Import Retailers</h3>

              </div>

              <!-- /.card-header -->

              <!-- form start -->

              <form role="form" method="POST" action="{{route('retailers.handleimport')}}" enctype="multipart/form-data">

                {{csrf_field()}}

                <div class="card-body">

                  <div class="form-group">

                    <label for="exampleInputFile">Select CSV File</label>

                    <div class="input-group">

                      <div class="custom-file">

                        <input type="file" class="form-control" id="exampleInputFile" name="file">

                      </div>

                    </div>

                  </div>

                </div>

                <!-- /.card-body -->



                <div class="card-footer">

                  <button type="submit" class="btn btn-primary">IMPORT</button>

                </div>

              </form>

            </div>

          </div>



          <div class="col-8"></div>

          

          <div class="col-12" style="background: white">

            @if(isset($report_error))

              <table class="table table-bordered">

                <thead>

                  <th>Shopname</th>

                  <th>Retailer Code</th>

                  <th>Distributor Code</th>

                  <th>Owner Name</th>

                  <th>RMN</th>

                  <th>Email</th>

                  <th>TM Name</th>

                  <th>TM Email</th>

                  <th>Address</th>

                  <th>Message</th>

                </thead>



                <tbody>

                  @foreach($report_error as $k => $v)

                    <tr>

                      <td>{{$v['shopname']}}</td>

                      <td>{{$v['retailer_code']}}</td>

                      <td>{{$v['distributor_code']}}</td>

                      <td>{{$v['ownername']}}</td>

                      <td>{{$v['rmn']}}</td>

                      <td>{{$v['email']}}</td>

                      <td>{{$v['tmname']}}</td>

                      <td>{{$v['tmemail']}}</td>

                      <td>{{$v['address']}}</td>

                      <td><code>{{$v['message']}} at row number {{$v['RowNumber']}}</code></td>

                    </tr>

                  @endforeach

                </tbody>

              </table>

            @else

            @endif

          </div>



        </div>


        <div class="row col-12">

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{asset('/samples/retailer.csv')}}" download>Download Sample Template</a>

        </div>

        <div class="row col-12">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{asset('/samples/retailer.csv')}}" download>Download Sample Template</a>
        </div>
        <!-- /.col -->

      </div>

      <!-- /.row -->

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->





@endsection



@section('footer-resource')

<!-- REQUIRED SCRIPTS -->



<!-- jQuery -->

<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap -->

<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- AdminLTE -->

<script src="{{asset('dist/js/adminlte.js')}}"></script>





<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>

<!-- Toastr -->

<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>



<!-- Select2 -->

<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>

<!-- Bootstrap4 Duallistbox -->

<script src="{{asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>



<script src="{{asset('js/marico.js')}}"></script>



</body>

</html>



@endsection




@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br>
    <section class="content">
      <div class="row" style="background: white; border-radius: 10px; padding: 10px">
        
        <div class="col-4">
          
          <div class="form-group">
            <label for="">Retailer Code</label>
            <input type="text" class="form-control" id="retailer_code" name="retailer_code" placeholder="Enter Retailer Code" onblur="load_retailer_info(this.value)">

            <input type="hidden" class="form-control" id="retailer_id" name="retailer_id">
          </div>

          <div class="form-group">
            <label for="">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
          </div>

          <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
          </div>

          <div class="form-group">
            <label for="">Bazar</label>
            <input type="text" class="form-control" id="bazar" name="bazar" placeholder="">
          </div>

          <div class="form-group">
            <label for="">Location</label>
            <input type="text" class="form-control" id="location" name="location">
          </div>

          <div class="form-group">
            <label for="">Business Aarea</label>
            <select class="form-control" name="businessarea">
              <option value="">SELECT</option>
              <option value="Brand/Product">Brand/Product</option>
              <option value="Others">Others</option>
            </select>
          </div>

        </div>

        <div class="col-4">
          
          <div class="form-group">
            <label for="">Query</label>
            <textarea class="form-control" name="query"></textarea>
          </div>

          <div class="form-group">
            <label for="">Request</label>
            <textarea class="form-control" name="request"></textarea>
          </div>

          <div class="form-group">
            <label for="">Solution</label>
            <select class="form-control" name="solution">
              <option value="">SELECT</option>
              <option value="Solved">Solved</option>
              <option value="Unsolved">Unsolved</option>
            </select>
          </div>

          <div class="form-group">
            <label for="">Call Type</label>
            <select class="form-control" name="calltype">
              <option value="">SELECT</option>
              <option value="New">New</option>
              <option value="Repeat">Repeat</option>
            </select>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="">District</label>
                <input type="text" class="form-control" id="district" name="district" readonly="">
              </div>              
            </div>

            <div class="col-6">
              <div class="form-group">
                <label for="">Town</label>
                <input type="text" class="form-control" id="town" name="town" readonly="">
              </div>
            </div>
          </div>

        </div>

        <div class="col-4">

          <div class="form-group">
            <label for="">Shop Name</label>
            <input type="text" class="form-control" id="shopname" name="shopname" readonly="">
          </div>

          <div class="form-group">
            <label for="">Registered Phone Number</label>
            <input type="text" class="form-control" id="rmn" name="rmn" readonly="">
          </div>

          <div class="form-group">
            <label for="">HQ</label>
            <input type="text" class="form-control" id="hq" name="hq" readonly="">
          </div>

          <div class="form-group">
            <label for="">DSH</label>
            <input type="text" class="form-control" id="dsh" name="dsh" readonly="">
          </div>

          <div class="form-group">
            <label for="">RH</label>
            <input type="text" class="form-control" id="rh" name="rh" readonly="">
          </div>

          <div class="form-group">
            <label for="">Scheme</label>
            <input type="text" class="form-control" id="scheme" name="scheme" readonly="">
          </div>

        </div>

      </div>

      <div class="row">
        
        <div class="col-2">
          
        </div>

        <div class="col-8">
          
        </div>

        <div class="col-2">
          
        </div>

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

  function load_retailer_info(code){
    $.ajax({
        dataType: "json",
        url: "{{url('/')}}/retailers/getinfo/"+code,
        success: function (data) {
            $("#shopname").val(data.shopname);
            $("#retailer_id").val(data.retailer_id);
            $("#district").val(data.district);
            $("#town").val(data.town);
            $("#rmn").val(data.rmn);
            $("#hq").val(data.hq);
            $("#dsh").val(data.dsh);
            $("#rh").val(data.rh);
            $("#scheme").val(data.scheme);
        }
    });
  }
  
</script>

</body>
</html>

@endsection




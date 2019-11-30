@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <br>
    <section class="content">
      <form method="POST" id="create" action="{{route('sales.store')}}">
        <div class="row" style="background: white; border-radius: 10px; padding: 10px">
          {{csrf_field()}}
          <div class="col-4">
            
            <div class="form-group">
              <label for="">Retailer Code</label><code>*</code>
              <input type="text" class="form-control" id="retailer_code" name="retailer_code" placeholder="Enter Retailer Code" onblur="load_retailer_info(this.value)">

              <input type="hidden" class="form-control" id="retailer_id" name="retailer_id">
            </div>

            <div class="form-group">
              <label for="">Phone Number</label><code>*</code>
              <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
            </div>

            <div class="form-group">
              <label for="">Name</label><code>*</code>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
            </div>

            <div class="form-group">
              <label for="">Bazar</label><code>*</code>
              <input type="text" class="form-control" id="bazar" name="bazar" placeholder="">
            </div>

            <div class="form-group">
              <label for="">Location</label><code>*</code>
              <input type="text" class="form-control" id="location" name="location">
            </div>

            <div class="form-group">
              <label for="">Business Aarea</label><code>*</code>
              <select class="form-control" name="businessarea">
                <option value="">SELECT</option>
                <option value="Brand/Product">Brand/Product</option>
                <option value="Others">Others</option>
              </select>
            </div>

          </div>

          <div class="col-4">
            
            <div class="form-group">
              <label for="">Query</label><code>*</code>
              <textarea class="form-control" name="quest"></textarea>
            </div>

            <div class="form-group">
              <label for="">Request</label><code>*</code>
              <textarea class="form-control" name="req"></textarea>
            </div>

            <div class="form-group">
              <label for="">Solution</label><code>*</code>
              <select class="form-control" name="solution">
                <option value="">SELECT</option>
                <option value="Solved">Solved</option>
                <option value="Unsolved">Unsolved</option>
              </select>
            </div>

            <div class="form-group">
              <label for="">Call Type</label><code>*</code>
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

        <div class="row" style="background: white; border-radius: 10px; padding: 10px">
          
          <div class="col-1">
            
          </div>

          <div class="col-10">
            <div id="orderItems">
              <table class="table">
                <thead>
                  <th>Product</th>
                  <th>Rate</th>
                  <th>Quantity</th>
                  <th>Subtotal</th>
                  <th>Action</th>
                </thead>

                <tbody id="formElements">
                  
                </tbody>

                <tfoot>
                  <tr>
                    <td colspan="3">Total</td>
                    <td><span id="total" style="font-weight: bold;"></span></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>

          <div class="col-1">
            <span class="btn btn-default bg-olive" onclick="addRow()">ADD</span>
          </div>

          <div class="row col-12">
            <div class="col-5"></div>
            <div class="col-2">
              <button class='btn btn-block btn-success btn-sm' id='submit' type='submit'>SUBMIT</button>
              <button class='btn btn-block btn-success btn-sm' id='loading' style='display: none' disabled=''>Working...</button>
            </div>
            <div class="col-5"></div>
          </div>

        </div>
        <!-- /.row -->
      </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class='modal-header'>
        <h4 class="modal-title">Please Correct the Following Errors</h4>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
        </div>
        <div class='alert alert-danger print-error-msg' id='error_messages' style='display:none'>
          <ul></ul>
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

<script src="{{asset('js/sales.js')}}"></script>

<script type="text/javascript">
  
   var total = 0;

  $(function () {
    $("#example1").DataTable();
  });

  function addRow(){

    $.ajax({
        dataType: "json",
        url: "{{url('/')}}/sales/orderdetails/add",
        success: function (data) {
            $("#formElements").prepend(JSON.stringify(data));
        }
    });

  }


  $('#formElements').on("click",".delete", function(e){
      e.preventDefault(); 
      $(this).parent().parent().remove();
      var sutract = $(this).parent().parent().find(".subtotal").val();
      total = total-sutract;
      $("#total").text(total.toFixed(2));
  })

  //Fetch Ptice
  $('#formElements').on("change",".prod_id", function(e){

    var rate = $(this).parent().parent().find(".rate");

    $.ajax({
        dataType: "json",
        url: "{{url('/')}}/sales/getprice/"+$(this).val(),
        success: function (data) {
          rate.val(data.unitprice);
        }
    });

  })

  //Calculate individual products price

  $('#formElements').on("input",".qty", function(e){

    total = 0;

    var rate = $(this).parent().parent().find(".rate").val();
    var subtotal = $(this).parent().parent().find(".subtotal");
    var subTotVal = $(this).val() * rate;
    subtotal.val(subTotVal.toFixed(2));

    $('.subtotal').each(function (index, element) {
        total = total + parseFloat($(element).val());
    });

    $("#total").text(total.toFixed(2));

  })


  //Ondelete quantity update total

  $('#formElements').on("keydown",".qty", function(e){

    var rate = $(this).parent().parent().find(".rate").val();
    var subtotal = $(this).parent().parent().find(".subtotal");
    var subTotVal = 0;

    var sub = $('#formElements').find(".subtotal");


    var KeyID = e.which;
   
    switch(KeyID)
     {
        case 8:
          $('.subtotal').each(function (index, element) {
              total = total + parseFloat($(element).val());
          });
        break; 
        case 46:
          $('.subtotal').each(function (index, element) {
              total = total + parseFloat($(element).val());
          });
        break;
        default:
        break;
     }

     $("#total").text(total.toFixed(2));

  })

  //Load Retailer Info
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




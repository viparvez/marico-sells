<div class="alert alert-danger print-error-msg" style="display:none">
    <ul></ul>
</div>

<form role="form" action="{{route('retailers.update', $ret->id)}}" id="update" method="POST">
  <div class="card-body">

    {{csrf_field()}}
    <input type="hidden" name="_method" value="PUT">

    <div class="row col-12">
            <div class="col-6">
              <div class="form-group">
                <label for="">Shop Name</label><code>*</code>
                <input type="text" class="form-control" id="shopname" name="shopname" placeholder="Shop Name" value="{{$ret->shopname}}">
              </div>

              <div class="form-group">
                <label for="">Retailer Code</label><code>*</code>
                <input type="text" class="form-control" id="code" name="code" placeholder="Retailer Code" value="{{$ret->code}}">
              </div>

              <div class="form-group">
                <label for="">Distributor</label><code>*</code>
                <select name="distributor_id" class="form-control">
                  <option value="{{$ret->Distributor->id}}">{{$ret->Distributor->code}} - {{$ret->Distributor->distributorname}}</option>
                  @foreach($distributors as $k => $v)
                    <option value="{{$v->id}}">{{$v->code}} - {{$v->distributorname}}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>Activate/Deactivate</label><code>*</code>
                <select name="active" class="form-control">
                  <option value="1" @if($ret->active == '1') selected @else @endif>Active</option>
                  <option value="0" @if($ret->active == '0') selected @else @endif>Deactive</option>
                </select>
              </div>
              
            </div>


            <div class="col-6">
              <div class="form-group">
                <label for="">Owner Name</label><code>*</code>
                <input type="text" class="form-control" id="ownername" name="ownername" placeholder="Owner Name" value="{{$ret->ownername}}">
              </div>

              <div class="form-group">
                <label for="">Registered Mobile Number (RMN)</label><code>*</code>
                <input type="text" name="rmn" class="form-control" placeholder="01890100100" value="{{$ret->rmn}}">
              </div>
              <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="example@example.com" value="{{$ret->email}}">
              </div>
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
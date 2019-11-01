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
                <label for="">Shop Name</label>
                <input type="text" class="form-control" id="shopname" name="shopname" placeholder="Enter Shop Name" value="{{$ret->shopname}}">
              </div>

              <div class="form-group">
                <label for="">Retailer Code</label>
                <input type="text" class="form-control" id="code" name="code" placeholder="Enter Retailer Code" value="{{$ret->code}}">
              </div>

              <div class="form-group">
                <label for="">Town</label>
                <select name="town_id" class="form-control">
                  <option value="{{$ret->Distributor->Town->id}}" selected>{{$ret->Distributor->Town->name}}</option>
                  @foreach($towns as $k => $v)
                    <option value="{{$v->id}}">{{$v->name}}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="">Owner Name</label>
                <input type="text" class="form-control" id="ownername" name="ownername" placeholder="Owner Name" value="{{$ret->ownername}}">
              </div>

              <div class="form-group">
                <label for="">Registered Mobile Number (RMN)</label>
                <input type="text" name="rmn" class="form-control" placeholder="01890100100" value="{{$ret->rmn}}">
              </div>

              <div class="form-group">
                <label>Activate/Deactivate</label>
                <select name="active" class="form-control">
                  <option value="1" @if($ret->active == '1') selected @else @endif>Active</option>
                  <option value="0" @if($ret->active == '0') selected @else @endif>Deactive</option>
                </select>
              </div>
              
            </div>


            <div class="col-6">
              <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="example@example.com" value="{{$ret->email}}">
              </div>

              <div class="form-group">
                <label for="">HQ</label>
                <input type="text" class="form-control" id="hq" name="hq" placeholder="" value="{{$ret->hq}}">
              </div>

              <div class="form-group">
                <label for="">DSH</label>
                <input type="text" class="form-control" id="dsh" name="dsh" placeholder="" value="{{$ret->dsh}}">
              </div>

              <div class="form-group">
                <label for="">RH</label>
                <input type="text" class="form-control" id="rh" name="rh" placeholder="" value="{{$ret->rh}}">
              </div>

              <div class="form-group">
                <label for="">Scheme</label>
                <input type="text" class="form-control" id="scheme" name="scheme" placeholder="" value="{{$ret->scheme}}">
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
<div class="alert alert-danger print-error-msg" style="display:none">
    <ul></ul>
</div>

<form role="form" action="{{route('products.update', $prod->id)}}" id="update" method="POST">
  <div class="card-body">

    {{csrf_field()}}
    <input type="hidden" name="_method" value="PUT">

    <div class="form-group">
      <label for="">Product Name</label>
      <input type="text" class="form-control" id="productName" name="name" placeholder="Enter Name" value="{{$prod->name}}">
    </div>

    <div class="form-group">
      <label for="">SKU Code</label>
      <input type="text" class="form-control" id="sku_code" name="sku_code" placeholder="SKU Code" value="{{$prod->sku_code}}">
    </div>

    <div class="form-group">
      <label for="">SKU Description</label>
      <textarea name="sku_desc" class="form-control">{{$prod->sku_desc}}</textarea>
    </div>

    <div class="form-group">
      <label for="">Unit Price</label>
      <input type="text" class="form-control" id="unitprice" name="unitprice" placeholder="Example: 10.90" value="{{$prod->unitprice}}">
    </div>

    <div class="form-group">
      <label>Activate/Deactivate</label>
      <select name="active" class="form-control">
        <option value="1" @if($prod->active == '1') selected @else @endif>Active</option>
        <option value="0" @if($prod->active == '0') selected @else @endif>Deactive</option>
      </select>
    </div>

  </div>
  <!-- /.card-body -->

  <div class="card-footer">
    <span class='btn btn-block btn-success btn-sm' id='submitEdit' onclick="update()">SAVE</span>
    <span class='btn btn-block btn-success btn-sm' id='loadingEdit' style='display: none' disabled=''>Working...</span>
  </div>
</form>
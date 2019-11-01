<tr>
  <td>
    <select class="form-control" name="product_id[]">
      @foreach($products as $k => $v)
        <option value="{{$v->id}}">{{$v->name}}</option>
      @endforeach
    </select>
  </td>
  <td>
    <input class="form-control" type="text" name="rate[]" readonly>
  </td>
  <td>
    <input class="form-control" type="number[]" name="">
  </td>
  <td></td>
  <span class=".delete btn btn-danger">REMOVE</span>
</tr>
<div class='box box-primary' style='font-weight:bold'>
	<div class='box-body box-profile'>
	  <table class='table table-striped details-view'>
	    <tr>
	      <td><b>Name</b></td> 
	      <td>{{$prod->name}}</td>
	    </tr>
	    <tr>
	      <td><b>Code</b></td>
	      <td>{{$prod->sku_code}}</td>
	    </tr>
	    <tr>
	      <td><b>Description</b></td>
	      <td>{{$prod->sku_desc}}</td>
	    </tr>
	    <tr>
	      <td><b>Unit Price</b></td>
	      <td>{{$prod->unitprice}}</td>
	    </tr>
	    <tr>
	      <td><b>Active</b></td>
	      <td>{{($prod->active == '1' ? 'YES' : 'NO')}}</td>
	    </tr>
	    <tr>
	      <td><b>Created By</b></td>
	      <td>{{$prod->CreatedBy->name}}</td>
	    </tr>
	    <tr>
	      <td><b>Created AT</b></td>
	      <td>{{$prod->created_at}}</td>
	    </tr>
	    <tr>
	      <td><b>Updated By</b></td>
	      <td>{{$prod->UpdatedBy->name}}</td>
	    </tr>
	    <tr>
	      <td><b>Updated At</b></td>
	      <td>{{$prod->updated_at}}</td>
	    </tr>
	  </table>

	  <a href='#' onclick="show('{{route('products.edit',$prod->id)}}','edit')" class='btn btn-primary btn-block'><b>EDIT</b></a>
	</div>
</div>
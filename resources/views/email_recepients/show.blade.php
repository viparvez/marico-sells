<div class='box box-primary' style='font-weight:bold'>
	<div class='box-body box-profile'>
	  <table class='table table-striped details-view'>
	    <tr>
	      <td><b>Name</b></td> 
	      <td>{{$district->name}}</td>
	    </tr>
	    <tr>
	      <td><b>Code</b></td>
	      <td>{{$district->code}}</td>
	    </tr>
	    <tr>
	      <td><b>Active</b></td>
	      <td>{{($district->active == '1' ? 'YES' : 'NO')}}</td>
	    </tr>
	    <tr>
	      <td><b>Created By</b></td>
	      <td>{{$district->CreatedBy->name}}</td>
	    </tr>
	    <tr>
	      <td><b>Created AT</b></td>
	      <td>{{$district->created_at}}</td>
	    </tr>
	    <tr>
	      <td><b>Updated By</b></td>
	      <td>{{$district->UpdatedBy->name}}</td>
	    </tr>
	    <tr>
	      <td><b>Updated At</b></td>
	      <td>{{$district->updated_at}}</td>
	    </tr>
	  </table>

	  <a href='#' onclick="show('{{route('districts.edit',$district->id)}}','edit')" class='btn btn-primary btn-block'><b>EDIT</b></a>
	</div>
</div>
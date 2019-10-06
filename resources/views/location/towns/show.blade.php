<div class='box box-primary' style='font-weight:bold'>
	<div class='box-body box-profile'>
	  <table class='table table-striped details-view'>
	    <tr>
	      <td><b>Name</b></td> 
	      <td>{{$town->name}}</td>
	    </tr>
	    <tr>
	      <td><b>Code</b></td>
	      <td>{{$town->code}}</td>
	    </tr>
	    <tr>
	      <td><b>Town</b></td>
	      <td>{{$town->District->name}}</td>
	    </tr>
	    <tr>
	      <td><b>Active</b></td>
	      <td>{{($town->active == '1' ? 'YES' : 'NO')}}</td>
	    </tr>
	    <tr>
	      <td><b>Created By</b></td>
	      <td>{{$town->CreatedBy->name}}</td>
	    </tr>
	    <tr>
	      <td><b>Created AT</b></td>
	      <td>{{$town->created_at}}</td>
	    </tr>
	    <tr>
	      <td><b>Updated By</b></td>
	      <td>{{$town->UpdatedBy->name}}</td>
	    </tr>
	    <tr>
	      <td><b>Updated At</b></td>
	      <td>{{$town->updated_at}}</td>
	    </tr>
	  </table>

	  <a href='#' onclick="show('{{route('towns.edit',$town->id)}}','edit')" class='btn btn-primary btn-block'><b>EDIT</b></a>
	</div>
</div>
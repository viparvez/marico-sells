<div class='box box-primary' style='font-weight:bold'>
	<div class='box-body box-profile'>
	  <table class='table table-striped details-view'>
	    <tr>
	      <td style="text-align: left; color: #000080"><b>Retailer Code</b></td> 
	      <td>{{$ret->code}}</td>
	      <td style="text-align: left; color: #000080"><b>HQ</b></td>
	      <td>{{$ret->hq}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Shop Name</b></td>
	      <td>{{$ret->shopname}}</td>
	      <td style="text-align: left; color: #000080"><b>DSH</b></td>
	      <td>{{$ret->dsh}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Town</b></td>
	      <td>{{$ret->Town->name}}</td>
	      <td style="text-align: left; color: #000080"><b>RH</b></td>
	      <td>{{$ret->rh}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Owner Name</b></td>
	      <td>{{$ret->ownername}}</td>
	      <td style="text-align: left; color: #000080"><b>Scheme</b></td>
	      <td>{{$ret->scheme}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Registered Mobile Number</b></td>
	      <td>{{$ret->rmn}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Email</b></td>
	      <td>{{$ret->email}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Active</b></td>
	      <td>{{($ret->active == '1' ? 'YES' : 'NO')}}</td>
	    </tr>
	      
	    <tr>
	      <td style="text-align: left; color: #000080"><b>Created By</b></td>
	      <td>{{$ret->CreatedBy->name}}</td>
	      <td style="text-align: left; color: #000080"><b>Created AT</b></td>
	      <td>{{$ret->created_at}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Updated By</b></td>
	      <td>{{$ret->UpdatedBy->name}}</td>
	      <td style="text-align: left; color: #000080"><b>Updated At</b></td>
	      <td>{{$ret->updated_at}}</td>
	    </tr>
	    
	  </table>

	  <a href='#' onclick="show('{{route('retailers.edit',$ret->id)}}','edit')" class='btn btn-primary btn-block'><b>EDIT</b></a>
	</div>
</div>
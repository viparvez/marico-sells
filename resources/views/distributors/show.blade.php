<div class='box box-primary' style='font-weight:bold'>
	<div class='box-body box-profile'>
	  <table class='table table-striped details-view'>
	    <tr>
	      <td style="text-align: left; color: #000080"><b>Distributor Code</b></td> 
	      <td>{{$dist->code}}</td>
	      <td style="text-align: left; color: #000080"><b>HQ</b></td>
	      <td>{{$dist->hq}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Registered Business Name</b></td>
	      <td>{{$dist->distributorname}}</td>
	      <td style="text-align: left; color: #000080"><b>DSH</b></td>
	      <td>{{$dist->dsh}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Town</b></td>
	      <td>{{$dist->Town->name}}</td>
	      <td style="text-align: left; color: #000080"><b>RH</b></td>
	      <td>{{$dist->rh}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Owner Name</b></td>
	      <td>{{$dist->ownername}}</td>
	      <td style="text-align: left; color: #000080"><b>Scheme</b></td>
	      <td>{{$dist->scheme}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Registered Mobile Number</b></td>
	      <td>{{$dist->rmn}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Email</b></td>
	      <td>{{$dist->email}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Active</b></td>
	      <td>{{($dist->active == '1' ? 'YES' : 'NO')}}</td>
	    </tr>
	      
	    <tr>
	      <td style="text-align: left; color: #000080"><b>Created By</b></td>
	      <td>{{$dist->CreatedBy->name}}</td>
	      <td style="text-align: left; color: #000080"><b>Created AT</b></td>
	      <td>{{$dist->created_at}}</td>
	    </tr>

	    <tr>
	      <td style="text-align: left; color: #000080"><b>Updated By</b></td>
	      <td>{{$dist->UpdatedBy->name}}</td>
	      <td style="text-align: left; color: #000080"><b>Updated At</b></td>
	      <td>{{$dist->updated_at}}</td>
	    </tr>
	    
	  </table>

	  <a href='#' onclick="show('{{route('distributors.edit',$dist->id)}}','edit')" class='btn btn-primary btn-block'><b>EDIT</b></a>
	</div>
</div>
<div class='box box-primary' style='font-weight:bold'>
	<div class='box-body box-profile'>
	  <table class='table table-striped details-view'>
	    <tr>
	      <td style="color: blue"><b>Name</b></td> 
	      <td>{{$user->name}}</td>
	      <td style="color: blue"><b>Email</b></td>
	      <td>{{$user->email}}</td>
	    </tr>
	    <tr>
	      <td style="color: blue"><b>Username</b></td>
	      <td>{{$user->username}}</td>
	      <td style="color: blue"><b>Gender</b></td>
	      <td>{{$user->gender}}</td>
	    </tr>

	    <tr>
	      <td style="color: blue"><b>Role</b></td>
	      <td>{{$user->role}}</td>
	      <td style="color: blue"><b>Active</b></td>
	      <td>{{($user->active == '1' ? 'YES' : 'NO')}}</td>
	    </tr>

	    <tr>
	      <td style="color: blue"><b>Created By</b></td>
	      <td>{{$user->CreatedBy->name}}</td>
	      <td style="color: blue"><b>Created AT</b></td>
	      <td>{{$user->created_at}}</td>
	    </tr>

	    <tr>
	      <td style="color: blue"><b>Updated By</b></td>
	      <td>{{$user->UpdatedBy->name}}</td>
	      <td style="color: blue"><b>Updated At</b></td>
	      <td>{{$user->updated_at}}</td>
	    </tr>

	  </table>

	  <a href='#' onclick="show('{{route('users.edit',$user->id)}}','edit')" class='btn btn-primary btn-block'><b>EDIT</b></a>
	</div>
</div>
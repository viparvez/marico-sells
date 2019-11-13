<div class='box box-primary' style='font-weight:bold'>
	<div class="col-12 row">
		<div class="col-3"></div>
		<div class="col-4">
			
			<form action="{{route('recepients.destroy', $id)}}" method="POST" id="update">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="delete">
				<h2>SURE? <span class="btn btn-warning" onclick="update()">YES</span></h2>
				<br>
			</form>
		</div>
		<div class="col-5"></div>
	</div>
</div>
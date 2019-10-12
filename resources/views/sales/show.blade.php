
<style type="text/css">
	.cell{
		background: #E8E8E8;
		font-weight: bold;
	}
</style>
<div class="col-12 row" style="padding: 15px">
	<h3><i>ORDER ID#  <span style="text-decoration: underline; color: blue">{{$sale->code}}<br></span></i></h3>
	<table class="table">
		<tbody>
			<tr>
				<td class="cell">Retailer Code</td>
				<td>{{$sale->Retailer->code}}</td>
				<td class="cell">Shop Name</td>
				<td>{{$sale->Retailer->shopname}}</td>
				<td class="cell">Scheme</td>
				<td>{{$sale->Retailer->scheme}}</td>
			</tr>

			<tr>
				<td class="cell">Phone Number</td>
				<td>{{$sale->phone}}</td>
				<td class="cell">RMN</td>
				<td>{{$sale->Retailer->rmn}}</td>
				<td class="cell">RH</td>
				<td>{{$sale->Retailer->rh}}</td>
			</tr>

			<tr>
				<td class="cell">Name</td>
				<td>{{$sale->name}}</td>
				<td class="cell">HQ</td>
				<td>{{$sale->Retailer->hq}}</td>
				<td class="cell">Query</td>
				<td>{{$sale->quest}}</td>
			</tr>

			<tr>
				<td class="cell">District</td>
				<td>{{$sale->Retailer->Town->District->name}}</td>
				<td class="cell">Bazar</td>
				<td>{{$sale->bazar}}</td>
				<td class="cell">Request</td>
				<td>{{$sale->req}}</td>
				
			</tr>

			<tr>
				<td class="cell">Town</td>
				<td>{{$sale->Retailer->Town->name}}</td>
				<td class="cell">Location</td>
				<td>{{$sale->location}}</td>
				<td class="cell">Solution</td>
				<td>{{$sale->solution}}</td>
			</tr>

			<tr>
				<td class="cell">Business Area</td>
				<td>{{$sale->businessarea}}</td>
				<td class="cell">DSH</td>
				<td>{{$sale->Retailer->dsh}}</td>
				<td class="cell">Call Type</td>
				<td>{{$sale->calltype}}</td>
			</tr>


			<tr>
				<table class="table table-bordered">
					<thead style="background: #6699FF">
						<th>#SL</th>
						<th>Product</th>
						<th>SKU Code</th>
						<th>Rate</th>
						<th>Quantity</th>
						<th>Subtotal</th>
					</thead>

					<tbody>

						@php
							$total = 0;
						@endphp

						@foreach($sale->Orderdetail as $k => $v)
							<tr>
								<td>{{$k+1}}</td>
								<td>{{$v->Product->name}}</td>
								<td>{{$v->Product->sku_code}}</td>
								<td>{{$v->unitprice}}</td>
								<td>{{$v->qty}}</td>
								<td>{{$v->subtotal}}</td>
							</tr>
							@php
								$total = $total + $v->subtotal;
							@endphp

						@endforeach

						<tr>
							<td colspan="5" style="text-align: right; font-weight: bold;">TOTAL</td>
							<td style="font-weight: bold;">{{$total}}</td>
						</tr>
					</tbody>
				</table>
			</tr>
		</tbody>
	</table>
	
</div>
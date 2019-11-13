<!DOCTYPE html>
<html>
<head>
	<meta name="content-disposition" content="inline; filename=filename.xls">
</head>
<body>
	<table border="1">
		<thead>
			<tr>
				<th>SL</th>
				<th>Order Code</th>
				<th>Retailer Name</th>
				<th>Retailer Code</th>
				<th>Distributor Name</th>
				<th>Distributor Code</th>
				<th>Retailer Phone Number</th>
				<th>SKU Name</th>
				<th>SKU Code</th>
				<th>SKU Description</th>
				<th>Unit Price</th>
				<th>Quantity</th>
				<th>Subtotal</th>
				<th>Date</th>
			</tr>
		</thead>

		<tbody>
			@foreach($orders as $k => $v)
			<tr>
				<td>{{$k+1}}</td>
				<td>{{$v->Order->code}}</td>
				<td>{{$v->Order->Retailer->shopname}}</td>
				<td>{{$v->Order->Retailer->code}}</td>
				<td>{{$v->Order->Retailer->Distributor->distributorname}}</td>
				<td>{{$v->Order->Retailer->Distributor->code}}</td>
				<td>{{$v->Order->Retailer->rmn}}</td>
				<td>{{$v->Product->name}}</td>
				<td>{{$v->Product->sku_code}}</td>
				<td>{{$v->Product->sku_description}}</td>
				<td>{{$v->unitprice}}</td>
				<td>{{$v->qty}}</td>
				<td>{{$v->subtotal}}</td>
				<td>{{date('Y-m-d', strtotime($v->created_at))}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>
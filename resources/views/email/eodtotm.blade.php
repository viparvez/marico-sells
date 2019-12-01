<table style="height: 57px; width: 767px;" border="1" cellpadding="2">
<tbody>

<tr>
<td style="width: 123px;">Order Number</td>
<td style="width: 258px;" colspan="2"><b> {{$value->code}}</b></td>
<td style="width: 142px;">Retailer Code</td>
<td style="width: 219px;" colspan="2"><b> {{$value->Retailer->code}}</b></td>
</tr>

<tr>
<td style="width: 123px;">Shop Name</td>
<td style="width: 258px;" colspan="2"><b> {{$value->Retailer->shopname}}</b></td>
<td style="width: 142px;">Phone Number</td>
<td style="width: 219px;" colspan="2"><b> {{$value->phone}}</b></td>
</tr>

<tr style="background-color: #5da6d6;">
<td style="width: 29px; text-align: center;"><strong>SL</strong></td>
<td style="width: 139px; text-align: center;"><strong>SKU Name</strong></td>
<td style="width: 141px; text-align: center;"><strong>SKU Code</strong></td>
<td style="width: 103px; text-align: center;"><strong>Unit price</strong></td>
<td style="width: 86px; text-align: center;"><strong>QTY</strong></td>
<td style="width: 92px; text-align: center;"><strong>Total</strong></td>
</tr>

@php
	$total = 0;
@endphp

@foreach($value->Orderdetail as $k=>$v)
<tr style="background-color: #d0d8cc;">
<td style="width: 29px; text-align: center;">{{$k+1}}</td>
<td style="width: 139px; text-align: center;">{{$v->Product->name}}</td>
<td style="width: 141px; text-align: center;">{{$v->Product->sku_code}}</td>
<td style="width: 145px; text-align: center;">{{number_format($v->unitprice, 2, '.', ',')}}</td>
<td style="width: 103px; text-align: center;">{{$v->qty}}</td>
<td style="width: 86px; text-align: center;">{{number_format($v->subtotal, 2, '.', ',')}}</td>
</tr>

@php
	$total = $total + $v->subtotal;
@endphp

@endforeach
<tr>
<td style="text-align: right;" colspan="5"><strong>SUBTOTAL</strong></td>
<td style="width: 92px; text-align: center;">{{number_format($total, 2, '.', ',')}}</td>
</tr>
</tbody>
</table>

<p style="padding-top: 50px"></p>
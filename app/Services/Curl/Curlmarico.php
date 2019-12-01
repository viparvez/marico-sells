<?php

namespace App\Services\Curl;
use App\Order;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Log;
/**
 * 
 */
class Curlmarico
{

	public function notifysale($id) {
		
		$url = "https://mblgtwebapidt.maricoapps.biz/api/ApiExternal/Telecaller_Order";
		$data = $this->prepareSalesData($id);
		$header = $data['order']['created_by'].date('d/m/Y');

		$response = $this->CurlPost($url, $data, $header);

		$this->logCurl($response);
		
	}

	private function prepareSalesData($id) {

		$order = Order::where(['id' => $id])->first();

        foreach ($order->Orderdetail as $key => $value) {
          $orderdetails[] = array(
            "sku_code" => $value->Product->sku_code,
            "sku_name" => $value->Product->name,
            "sku_desc" => $value->Product->sku_desc,
            "unitprice" => number_format($value->unitprice,2),
            "quantity" => $value->qty,
            "total_price" => number_format($value->subtotal,2)
          );
        }

        $data = array(
          "distributor" => array(
            "code" => $order->Retailer->Distributor->code,
            "name" => $order->Retailer->Distributor->distributorname,
            "district" => array(
              "code" => $order->Retailer->Distributor->Town->District->code,
              "name" => $order->Retailer->Distributor->Town->District->name
            )
          ),
          "retailer" => array(
            "code" => $order->Retailer->code,
            "name" => $order->Retailer->shopname
          ),
          "beat_desc" => "WADALA GAON (WK)",
          "order" => array(
            "order_id" => $order->code,           
            "created_at" => $order->created_at,
            "updated_at" => $order->updated_at,
            "created_by" => $order->CreatedBy->username,    
            "createdby_name" => $order->CreatedBy->username,
            "particulars" => $orderdetails
          ),
          "download_flag" => "N",
          "cs_download_flag" => "N"
        );

        return $data;
	}

	private function CurlPost($url, $data, $header){
		
		$response = Curl::to($url)
        ->withData( $data )
        ->withHeader("marico_access_tokenid: $header")
        ->asJson()
        ->post();

		return $response;        
	
	}

	private function logCurl($response){
		Log::channel('maricolog')->info(date('Y-m-d h:i:s'). ' : '. $response);
	}
}
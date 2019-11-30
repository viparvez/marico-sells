<?php



namespace App\Services\Product;

use App\Product;



/**

 * 

 */

class Productimport

{

	protected $products = [];

	protected $valid = true;

	protected $errorRows = [];

	protected $validRows = [];

	

	public function checkImportData($rows) {

		$sku_code = array();

		foreach ($rows as $key => $row) {
			array_push($sku_code,$row[1]);
		}


		foreach ($rows as $key => $row) {

			if (empty($row[0])) {

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Name required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			}elseif(empty($row[1])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'SKU Code required';

				$this->errorRows[$key] = $row;

				$this->valid = false;


			}elseif(empty($row[2])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Description required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			}elseif (!$this->checkValidPrice($row[3])) {

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Invalid Price';

				$this->errorRows[$key] = $row;

				$this->valid = false;

			}

			if ($this->count_array_values($sku_code, $row[1]) > 1) {
					
				$row['RowNumber'] = $key+2;					

				$row['message'] = 'Duplicate SKU Code in provided file';

				$this->errorRows[$key] = $row;

				$this->valid = false;

			}

			if ($this->chekDuplicateCodeDB($row[1]) === 'false') {
					
				$row['RowNumber'] = $key+2;					

				$row['message'] = 'Duplicate SKU Code';

				$this->errorRows[$key] = $row;

				$this->valid = false;

			}


		}



		return $this->errorRows;



	}



	//Check if price is OK



	private function checkValidPrice($price){

		return is_numeric($price);

	}



	private function chekDuplicateCodeDB($code) {

		$result =  Product::where(['sku_code' => $code])->first();

		if (empty($result->sku_code)) {

		   return 'true';

		} else {

			return 'false';

		}


	}



	//Get Error Message



	public static function getError(){

		return response()->json(['message'=>'Successful']);

	}

	function count_array_values($my_array, $match) 
	{ 
    		$count = 0; 
    
    		foreach ($my_array as $key => $value) 
    		{ 
        		if ($value == $match) 
        		{ 
            			$count++; 
        		} 
    		} 
    
    		return $count; 
	} 


}
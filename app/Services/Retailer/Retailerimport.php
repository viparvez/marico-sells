<?php



namespace App\Services\Retailer;

use App\Retailer;

use App\Town;

use App\Distributor;



/**

 * 

 */

class Retailerimport

{

	protected $products = [];

	protected $valid = true;

	protected $errorRows = [];

	protected $validRows = [];

	

	public function checkImportData($rows) {

		$ret_code = array();

		foreach ($rows as $key => $row) {
			array_push($ret_code,$row[0]);
		}

		foreach ($rows as $key => $row) {

			if (empty($row[0])) {

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Shopname required';

				$this->errorRows[$key] = $row;

				$this->valid = false;

			} 


			if ($this->count_array_values($ret_code, $row[1]) > 1) {
					
				$row['RowNumber'] = $key+2;					

				$row['message'] = 'Duplicate Retailer Code in provided file';

				$this->errorRows[$key] = $row;

				$this->valid = false;

			}



			if (empty($row[1])) {

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Retailer code required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			} else {

				

				if ($this->chekDuplicateCodeDB($row[0]) === 'false') {
					
					$row['RowNumber'] = $key+2;

					$row['message'] = 'Duplicate Code';

					$this->errorRows[$key] = $row;

					$this->valid = false;

				}

			}



			

			if(empty($row[2])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Distributor Code required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			} else {



				if ($this->checkDist($row[2]) === 'false') {

					$row['RowNumber'] = $key+2;

					$row['message'] = 'Invalid Distributor Code';

					$this->errorRows[$key] = $row;

					$this->valid = false;

				}



			}





			if(empty($row[3])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Owner Name Required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			} 





			if(empty($row[4])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'RMN Required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			} 





			if(!empty($row[5])){



				if (!filter_var($row[5], FILTER_VALIDATE_EMAIL)) {

				    $row['RowNumber'] = $key+2;

				    $row['message'] = 'Invalid Email';

				    $this->errorRows[$key] = $row;

				    $this->valid = false;

				} 



			} 





			if(empty($row[6])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Address Required';

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



	//duplicate code

	private function chekDuplicateCodeDB($code) {

		$result =  Retailer::where(['code' => $code])->first();



		if (empty($result->code)) {

		   return 'true';

		} else {

			return 'false';

		}



	}



	//invalid town code



	private function checkDist($code) {

		$result = Distributor::where(['code' => $code, 'deleted' => '0'])->first();



		if (empty($result->code)) {

		   return 'false';

		} else {

			return 'true';

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
<?php



namespace App\Services\Distributor;

use App\Distributor;

use App\Town;



/**

 * 

 */

class Distributorimport

{

	protected $products = [];

	protected $valid = true;

	protected $errorRows = [];

	protected $validRows = [];

	

	public function checkImportData($rows) {
		
		$dist_code=array();		

		foreach ($rows as $key => $row) {
			array_push($dist_code,$row[0]);
		}
		

		foreach ($rows as $key => $row) {
	
			if (empty($row[0])) {

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Distributor code required';

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
			
			if ($this->count_array_values($dist_code, $row[0]) > 1) {
					
				$row['RowNumber'] = $key+2;					

				$row['message'] = 'Duplicate Distributor Code in provided file';

				$this->errorRows[$key] = $row;

				$this->valid = false;

			}


			if(empty($row[1])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Town Code required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			} else {



				if ($this->checkTown($row[1]) === 'false') {

					$row['RowNumber'] = $key+2;

					$row['message'] = 'Invalid Town Code';

					$this->errorRows[$key] = $row;

					$this->valid = false;

				}



			}





			if(empty($row[2])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Owner Name Required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			} 





			if(empty($row[3])){

				$row['RowNumber'] = $key+2;
			
				$row['message'] = 'Registered Business Name Required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			} 





			if(empty($row[4])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'RMN Required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			} 





			if(empty($row[5])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Email Required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			} 



			if(empty($row[6])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'HQ Required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			} 



			if(empty($row[7])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'DSH Required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			} 





			if(empty($row[8])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'RH Required';

				$this->errorRows[$key] = $row;

				$this->valid = false;

			} 





			if(empty($row[9])){

				$row['RowNumber'] = $key+2;

				$row['message'] = 'Scheme Required';

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

		$result =  Distributor::where(['code' => $code])->first();

		if (empty($result->code)) {

		   return 'true';

		} else {

			return 'false';

		}

	}



	//invalid town code



	private function checkTown($code) {

		$result = Town::where(['code' => $code, 'deleted' => '0'])->first();

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
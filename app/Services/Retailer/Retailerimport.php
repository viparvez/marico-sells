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

		foreach ($rows as $key => $row) {

			if (empty($row[0])) {

				$row['message'] = 'Shopname required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} 


			if (empty($row[1])) {

				$row['message'] = 'Retailer code required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} else {
				
				if ($this->chekDuplicateCodeDB($row[0]) === 'false') {
					$row['message'] = 'Duplicate Code';
					$this->errorRows[$key] = $row;
					$this->valid = false;
				}
			}

			
			if(empty($row[2])){

				$row['message'] = 'Distributor Code required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} else {

				if ($this->checkDist($row[2]) === 'false') {
					$row['message'] = 'Invalid Distributor Code';
					$this->errorRows[$key] = $row;
					$this->valid = false;
				}

			}


			if(empty($row[3])){

				$row['message'] = 'Owner Name Required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} 


			if(empty($row[4])){

				$row['message'] = 'RMN Required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} 


			if(!empty($row[5])){

				if (!filter_var($row[5], FILTER_VALIDATE_EMAIL)) {
				    $row['message'] = 'Invalid Email';
				    $this->errorRows[$key] = $row;
				    $this->valid = false;
				} 

			} 


			if(empty($row[6])){

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

}
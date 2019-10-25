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

		foreach ($rows as $key => $row) {

			if (empty($row[0])) {

				$row['message'] = 'Distributor code required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} else {
				
				if ($this->chekDuplicateCodeDB($row[0]) === 'false') {
					$row['message'] = 'Duplicate Code';
					$this->errorRows[$key] = $row;
					$this->valid = false;
				}
			}

			
			if(empty($row[1])){

				$row['message'] = 'Town Code required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} else {

				if ($this->checkTown($row[1]) === 'false') {
					$row['message'] = 'Invalid Town Code';
					$this->errorRows[$key] = $row;
					$this->valid = false;
				}

			}


			if(empty($row[2])){

				$row['message'] = 'Owner Name Required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} 


			if(empty($row[3])){

				$row['message'] = 'Registered Business Name Required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} 


			if(empty($row[4])){

				$row['message'] = 'RMN Required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} 


			if(empty($row[5])){

				$row['message'] = 'Email Required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} 


			if(empty($row[6])){

				$row['message'] = 'HQ Required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} 

			if(empty($row[7])){

				$row['message'] = 'DSH Required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} 


			if(empty($row[8])){

				$row['message'] = 'RH Required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			} 


			if(empty($row[9])){

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

}
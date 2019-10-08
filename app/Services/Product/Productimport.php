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

		foreach ($rows as $key => $row) {

			if (empty($row[0])) {

				$row['message'] = 'Name required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			}elseif(empty($row[1])){

				$row['message'] = 'SKU Code required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			}elseif(empty($row[2])){

				$row['message'] = 'Description required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			}elseif (!$this->checkValidPrice($row[3])) {

				$row['message'] = 'Invalid Price';
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

	}

	//Get Error Message

	public static function getError(){
		return response()->json(['message'=>'Successful']);
	}

}
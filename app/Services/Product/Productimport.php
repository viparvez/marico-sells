<?php

namespace App\Services\Product;

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

		$prices = [];

		return $rows;

		foreach ($rows as $key => $row) {

			if (!$this->checkValidPrice($row[3])) {

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

	//Get Error Message

	public static function getError(){
		return response()->json(['message'=>'Successful']);
	}

}
<?php



namespace App\Services\District;

use App\District;



/**

 * 

 */

class Districtimport

{

	protected $valid = true;

	protected $errorRows = [];

	protected $validRows = [];

	

	public function checkImportData($rows) {



		foreach ($rows as $key => $row) {



			if (empty($row[0])) {

				$row['RowNumber'] = $key+2;
				
				$row['message'] = 'Name required';

				$this->errorRows[$key] = $row;

				$this->valid = false;



			}



		}



		return $this->errorRows;



	}



}
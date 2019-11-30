<?php

namespace App\Services\Town;
use App\District;

/**
 * 
 */
class Townimport
{
	protected $valid = true;
	protected $errorRows = [];
	protected $validRows = [];
	
	public function checkImportData($rows) {

		foreach ($rows as $key => $row) {

			if (empty($row[0])) {

				$row['message'] = 'District Code required';
				$this->errorRows[$key] = $row;
				$this->valid = false;

			}else {
				
				if ($this->checkDistrict($row[0]) === 'false') {
					$row['message'] = 'Invalid District Code';
					$this->errorRows[$key] = $row;
					$this->valid = false;
				}
			}

		}

		return $this->errorRows;

	}


	//invalid Dostrict code

	private function checkDistrict($code) {
		$result = District::where(['code' => $code, 'deleted' => '0'])->first();

		if (empty($result->code)) {
		   return 'false';
		} else {
			return 'true';
		}
	}
	

}
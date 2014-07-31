<?php

class SearchController extends BaseController {

    public function searchFulltext($input)
	{
	    $input = mysql_real_escape_string($input);
		$addresses = array();
	    $results = Address::whereRaw("MATCH(addressLine1, addressLine2, zipcode, phone, phoneAdditional) AGAINST('+{$input}*' IN BOOLEAN MODE)")
							->get();

		foreach ($results as $index => $value)
		{
			$addresses[] = array (
				'id'	=> $value->id,
				'value'	=> $value->addressLine1);
		}
		return json_encode($addresses);
	}

 
}
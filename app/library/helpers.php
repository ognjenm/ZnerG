<?php 

class Helper
{
	public static function getEnumValues($table, $field)
    {
	    $row = DB::table('INFORMATION_SCHEMA.COLUMNS')
	    				->select('COLUMN_TYPE')
	    				->where('TABLE_NAME', '=', $table)
	    				->where('COLUMN_NAME', '=', $field)
	    				->lists('COLUMN_TYPE');
	    if ($row)
	    {
		    $type = $row[0];
		    preg_match('/^enum\((.*)\)$/', $type, $matches);
		    foreach( explode(',', $matches[1]) as $value )
		    {
		    	$text = trim( $value, "'" );
		        $enum[$text] = trim($text);
		    }
		    return $enum;
		}
		else
			return 0;
	}

	public static function getModelName($modelName)
    {
    	preg_match('/\b[a-zA-Z]+\b/i', $modelName, $result);
	    return $result[0];
    }
	public static function isTable($name)
    {
    	//var_dump($name);
	    $row = DB::table('INFORMATION_SCHEMA.TABLES')
	    				->where('TABLE_NAME', '=', $name)
	    				->lists('TABLE_NAME');
	    if ($row)
	    	return 1;
	    else
	    	return 0;
	}

	public static function isTableModified($id_metaData, $schema, $name)
    {
    	$modifiedFields = array();

    	$fields = Field::select('name', 'default', 'isNullable', 'id_dataType', 'length', 'values')
    					->where('id_metaData', '=', $id_metaData)
    					->where('isActive', '=', 'Yes')
	    				->get();
	    foreach($fields as $field)
	    {
		    $columns = DB::table('INFORMATION_SCHEMA.COLUMNS')
	    	 			->select('COLUMN_NAME', 'COLUMN_DEFAULT', 'IS_NULLABLE', 'DATA_TYPE', 'CHARACTER_MAXIMUM_LENGTH', 'COLUMN_TYPE', 'NUMERIC_PRECISION', 'NUMERIC_SCALE')
	    				->where('TABLE_SCHEMA', '=', $schema)
	    				->where('TABLE_NAME', '=', $name)
	    				->where('COLUMN_NAME', '=', $field->name)
    					->first();
    		if ($columns)
    		{
    			if ($field->isLinked == 'No')
    			{
	    			if ($columns->COLUMN_DEFAULT != $field->default)
	    				$modifiedFields = $modifiedFields + array($field->name);
	    			if ($field->id_dataType)
	    			{
		    			$dataTypeName = DataType::where('id', '=', $field->id_dataType)
		    									->first()->name;
		    			if (strtoupper($columns->DATA_TYPE) != $dataTypeName)
		    				$modifiedFields = $modifiedFields + array($field->name);
		    			if ($dataTypeName == 'ENUM' && $columns->COLUMN_TYPE != $field->values)
		    				$modifiedFields = $modifiedFields + array($field->name);
		    		}
	    			if ($columns->CHARACTER_MAXIMUM_LENGTH != $field->length)
	    				$modifiedFields = $modifiedFields + array($field->name);
	    			if ($columns->NUMERIC_PRECISION != $field->precision)
	    				$modifiedFields = $modifiedFields + array($field->name);
	    			if ($columns->NUMERIC_SCALE != $field->scale)
	    				$modifiedFields = $modifiedFields + array($field->name);
	    		}
    			if ($field->isNullable == 'Yes')
    				$isNullable = 'YES';
    			else
					$isNullable = 'NO';
    			if ($columns->IS_NULLABLE != $isNullable)
    				$modifiedFields = $modifiedFields + array($field->name);
    		}
    		else
   				$modifiedFields = $modifiedFields + array($field->name);
		}		

    	$fields = Field::select('name')
    					->where('id_metaData', '=', $id_metaData)
    					->where('isActive', '=', 'Yes')
    					->lists('name');

	    $columns = DB::table('INFORMATION_SCHEMA.COLUMNS')
	    	 			->select('COLUMN_NAME')
	    				->where('TABLE_SCHEMA', '=', $schema)
	    				->where('TABLE_NAME', '=', $name)
	    				->whereNotIn('COLUMN_NAME', $fields)
	    				->get();

	    foreach($columns as $column)
	    {
	    	$modifiedFields = $modifiedFields + array($column->COLUMN_NAME);
	    }
		return $modifiedFields;
	}

	public static function isRequired($table, $field)
    {
	    $row = DB::table('INFORMATION_SCHEMA.COLUMNS')
	    				->select('IS_NULLABLE')
	    				->where('TABLE_NAME', '=', $table)
	    				->where('COLUMN_NAME', '=', $field)
	    				->lists('IS_NULLABLE');	
	    if ($row)
	    {
		    $type = $row[0];
		    if ($type == 'NO')
		    	$isRequired = 'Yes';
		    else
		    	$isRequired = 'No';
		    return $isRequired;
		}
		else
			return 0;
	}

	public static function getStructures($tableSchema, $structures)
    {
    	$newList = array();
	    $list = DB::table('INFORMATION_SCHEMA.TABLES')
	    				->select('TABLE_NAME as name')
	    				->where('TABLE_SCHEMA', '=', $tableSchema)
	    				->whereNotIn('TABLE_NAME', $structures)
	    				->where('TABLE_NAME', 'NOT LIKE', '_*')
	    				->lists('name');

	    foreach ($list as $key => $value)
	    {
	    	if ($value)
	    		$newList[$key] = array('name' => $value, 'created_at' => new DateTime, 'updated_at' => new DateTime);
	    }

		return $newList;
	}

	public static function loadCollaborators($id, $level, $count)
    {    	
		$collaborators = Employee::where('id', '=', $id)->get()->lists('full_name', 'id');
		$collaborators = $collaborators + Helper::getCollaborators(Auth::user()->id_employee, $collaborators, $level, $count);
		Session::put('collaborators', asort($collaborators));
		return $collaborators;
	}

	public static function getCollaborators($id, $collaborators, $level, $count)
    {    	
    	$directCollaborators = Employee::where('id_employeeToReport', '=', $id)->get();
    	if ($count < $level)
    	{
	    	foreach ($directCollaborators as $key => $value)
	    	{
	    		$collaborators = array_add($collaborators, $value->id, $value->full_name);
	    		$collaborators = Helper::getCollaborators($value->id, $collaborators, $level, $count + 1)	;
	    	}
	    }
    	return $collaborators;
    }

	public static function loadCampaigns($id, $level, $count)
    {    	
		// Get campaigns
		$myCampaigns = EmployeesCampaign::where('id_employee', '=', $id)->get()->lists('id_campaign');
		if ($myCampaigns)
			$campaigns = Campaign::whereIn('id', $myCampaigns)->get()->lists('name', 'id');
		else
			$campaigns = array();
		$campaigns = Helper::getCampaigns($id, $campaigns, $level, $count);
		Session::put('campaigns', asort($campaigns));
		return $campaigns;
	}

	public static function getCampaigns($id, $campaigns, $level, $count)
    {    	
		$myCampaigns = EmployeesCampaign::where('id_employee', '=', $id)->get()->lists('id_campaign');
		if ($myCampaigns)
			$otherCampaigns = Campaign::whereIn('id', $myCampaigns)->get()->lists('name', 'id');
		else
			$otherCampaigns = array();

    	$campaign = Campaign::where('id_responsible', '=', $id)->get()->lists('name', 'id');
   		$campaigns = $campaigns + $campaign + $otherCampaigns;
    	$directCollaborators = Employee::where('id_employeeToReport', '=', $id)->get();
    	if ($count < $level)
    	{
	    	foreach ($directCollaborators as $key => $value)
	    	{
	    		$campaigns = Helper::getCampaigns($value->id, $campaigns, $level, $count + 1)	;
	    	}
	    }
    	return $campaigns;
    }

public static function getOptionName($id)
{
  $optionName = MenuItem::where('position', '=', $id)->get()->first();
  return $optionName->name;
}

	public static function loadInitialActivities($id)
    {    	
    	// Filter by position
    	$initialActivities1 = Process::select('activitiesProcesses.name', 'activitiesProcesses.id' )
    						->join('activitiesProcesses', function($join)
    						{
    							$join->on('processes.id_initialActivity', '=', 'activitiesProcesses.id_activity')
    								->on('processes.id', '=', 'activitiesProcesses.id_process');
    						})
    						->join('activitiesPositions', 'activitiesPositions.id_activitiesProcess', '=', 'activitiesProcesses.id')
    						->join('employees', 'employees.id_position', '=', 'activitiesPositions.id_position')
    						->where('employees.id', '=', $id)
    						->get()->lists('name', 'id');
/* 
    	// Filter by level
    	$initialActivities1 = Process::select('activitiesProcesses.name', 'activitiesProcesses.id' )
    						->join('activitiesProcesses', function($join)
    						{
    							$join->on('processes.id_initialActivity', '=', 'activitiesProcesses.id_activity')
    								->on('processes.id', '=', 'activitiesProcesses.id_process');
    						})
    						->join('activitiesPositions', 'activitiesPositions.id_activitiesProcess', '=', 'activitiesProcesses.id')
    						->join('employees', 'employees.id_position', '=', 'activitiesPositions.id_position')
    						->where('employees.id', '=', $id)
    						->get()->lists('name', 'id');

    	// Filter by department
    	$initialActivities1 = Process::select('activitiesProcesses.name', 'activitiesProcesses.id' )
    						->join('activitiesProcesses', function($join)
    						{
    							$join->on('processes.id_initialActivity', '=', 'activitiesProcesses.id_activity')
    								->on('processes.id', '=', 'activitiesProcesses.id_process');
    						})
    						->join('activitiesPositions', 'activitiesPositions.id_activitiesProcess', '=', 'activitiesProcesses.id')
    						->join('employees', 'employees.id_position', '=', 'activitiesPositions.id_position')
    						->where('employees.id', '=', $id)
    						->get()->lists('name', 'id');
*/
    	// Filter by employee
    	$initialActivities = Process::select('activitiesProcesses.name', 'activitiesProcesses.id')
    						->join('activitiesProcesses', function($join)
    						{
    							$join->on('processes.id_initialActivity', '=', 'activitiesProcesses.id_activity')
    								->on('processes.id', '=', 'activitiesProcesses.id_process');
    						})
    						->join('activitiesEmployees', 'activitiesEmployees.id_activitiesProcess', '=', 'activitiesProcesses.id')
    						->join('employees', 'employees.id', '=', 'activitiesEmployees.id_employee')
    						->where('employees.id', '=', $id)
    						->get()->lists('name', 'id');


    	$initialActivities = $initialActivities1 + $initialActivities;

    	asort($initialActivities);
    	return $initialActivities;
    }

	public static function deleteDependent($id_fieldName, $id_metaData, &$input)
	{
		$fields = Field::where('id_metaData', '=', $id_metaData)
							->where('relations', 'LIKE', '%' . $id_fieldName .'%')
							->get();
		foreach ($fields as $key => $field)
		{
			self::deleteDependent($field->name, $id_metaData, $input);
			$input[$field->name] = '';
			$autocompleteFieldName = str_plural(substr($field->name, 3));
			$input[$autocompleteFieldName] = '';
		}
	}

	public static function getNearbyPlaces($lat, $lon, $radiusMeters, $sensor, $apiKey, $pagetoken, $rankby, $types)
	{
		if ($rankby == '')
		{
			if ($pagetoken == '')
				$details_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" . $lat . "," . $lon . "&radius=" . $radiusMeters . "&sensor=" . $sensor . "&key=" . $apiKey;
			else
				$details_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" . $lat . "," . $lon . "&pagetoken=" . $pagetoken . "&radius=" . $radiusMeters . "&sensor=" . $sensor . "&key=" . $apiKey;
		}
		else
		{
			if ($pagetoken == '')
				$details_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" . $lat . "," . $lon . "&rankby=" . $rankby . "&types=" . $types . "&sensor=" . $sensor . "&key=" . $apiKey;
			else
				$details_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" . $lat . "," . $lon . "&pagetoken=" . $pagetoken . "&rankby=" . $rankby . "&types=" . $types . "&sensor=" . $sensor . "&key=" . $apiKey;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $details_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);  

		return json_decode(curl_exec($ch), true);

	}
}

<?php

use LaravelBook\Ardent\Ardent;

class Business extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'businesses';
	protected $softDelete = true;
	protected $guarded = array('zipcode', 'id_address', 'id_statusLocation', 'isActive', 'isHeadquarter', 'isBilling', 'isShipping', 'id_typesBusiness');

	public $fieldName = 'name';
	public $filters = array(
		'id_database'				=> 'databases',
	);
	public $filtersWhere = array(
		'id_database'				=> null,
	);
	public $filtersTemp = array(
		'id_database'				=> 'databases',
	);
	public $wheres = array(
		'id_database'				=> 'databases',
	);
	public $orderBy = array(
		'name'				=> 'ASC',
	);
	public $autocomplete = array(
		'0' => 'field:name',
	);
	public static $rules = array(
		'name'                  => 'required',
	);

	public $arraySearchFields = array('name', 'email', 'website', 'note');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

    public function database()
    {
    	return $this->belongsTo('Database', 'id_database', 'id');
    }

	public function getNameAttribute()
   	{
        return $this->attributes['name'];
    }

	public function fulltextSearch($tableName, $term, $data)
	{
		$mainSearchFields = implode(',', $this->arraySearchFields);
		$mainField = $this->fieldName;

	    $results = DB::table($tableName);
		$searchFields = '';
	    foreach ($data as $field => $info)
	    {
	    	$table = strstr($info, '-', true);
	    	$value = substr(strstr($info, '-'),1);
	   		$results = $results->leftJoin($table, $tableName . '.id', '=', $table . '.id_' . str_singular($tableName))
	   							->where($table . '.' . $field, '=', $value);
	   	}
	   	if (Session::get('`') >= 5.6)
	   	{			
		   	$results = $results->where(function($query) use ($mainSearchFields, $term, $data)
									{
										$query->whereRaw("MATCH(" . $mainSearchFields . ") AGAINST('+{$term}*' IN BOOLEAN MODE)");
										foreach	($data as $field => $info)
										{						
		    								$table = strstr($info, '-', true);
											$modelName = ucfirst(str_singular($table));
											$entityTemp = new $modelName;
											$searchFields = implode(',', $entityTemp->arraySearchFields);
											$query = $query->orWhereRaw("MATCH(" . $searchFields . ") AGAINST('+{$term}*' IN BOOLEAN MODE)");
										}
									});
		}
		else
		{
			$searchFields = $this->arraySearchFields;
			$mainSearchTermBits = array();
			foreach ($searchFields as $field)
			{
			    $field = trim($field);
			    if (!empty($field)) {
			        $mainSearchTermBits[] = $field . " LIKE '%$term%'";
			    }
			}

		   	$results = $results->where(function($query) use ($mainSearchTermBits, $term, $data)
									{
										$query->whereRaw(implode(' OR ', $mainSearchTermBits));
										foreach	($data as $field => $info)
										{						
		    								$table = strstr($info, '-', true);
											$modelName = ucfirst(str_singular($table));
											$entityTemp = new $modelName;

											$searchFields = $entityTemp->arraySearchFields;
											$searchTermBits = array();
											foreach ($searchFields as $field)
											{
											    $field = trim($field);
											    if (!empty($field)) {
											        $searchTermBits[] = $field . " LIKE '%$term%'";
											    }
											}
											$query = $query->orWhereRaw(implode(' OR ', $searchTermBits));
										}
									});
		}
	    $results = $results->get();
	    //dd(DB::getQueryLog());
		$rows = array();
		if ($results)
		{
			foreach ($results as $index => $value)
			{
				$rows[] = array (
					'id'	=> $value->id,
					'value'	=> $value->$mainField . $value->id);
			}
		}
		return json_encode($rows);
	}
}

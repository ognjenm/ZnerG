<?php

use LaravelBook\Ardent\Ardent;

class State extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'states';
	protected $softDelete = true;
	protected $guarded = array();

	public $fieldName = 'name';
	public $filters = array(
		'id_country'				=> 'countries',
	);
	public $filtersWhere = array(
		'id_country'				=> null,
	);
	public $filtersTemp = array(
		'id_country'				=> 'countries',
	);
	public $wheres = array(
		'id_country'				=> 'countries',
	);
	public $orderBy = array(
		'name'					=> 'ASC',
	);

	public static $rules = array(
		'name'                  => 'required',
	);

	public $arraySearchFields = array('name', 'isActive');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

    public function organization()
    {
    	return $this->belongsTo('Organization', 'id_organization', 'id');

    }

    public function updateStatus()
    {
		$modelData = self::where('isActive', '=', 'Yes')->get();
		$dbName = DB::connection()->getDatabaseName();

		foreach ($modelData as $value)
		{
			$name = '_data_' . $value->id;
    		// Verify if the table for the metadata has been created
			if (Helper::isTable($name))
			{
		    	// If it has been created, verify if any field has been modified
		    	$modifiedFields = Helper::isTableModified($value->id, $dbName, $name);
		    	if (count($modifiedFields) > 0)
		    		$value->status = 'Modified';
		    	else
		    		$value->status = 'Updated';
			}
			else
			{
				$value->status = 'Not Created';
			}
			$value->autoHydrateEntityFromInput = false;    
			$value->forceEntityHydrationFromInput = false; 
			$value->save();
		}
    }

}

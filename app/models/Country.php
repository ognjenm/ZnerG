<?php

use LaravelBook\Ardent\Ardent;

class Country extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'countries';
	protected $softDelete = true;
	protected $guarded = array();

	public $fieldName = 'name';
	public $filters = array(
	);
	public $filtersWhere = array(
	);
	public $filtersTemp = array(
	);
	public $wheres = array(
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

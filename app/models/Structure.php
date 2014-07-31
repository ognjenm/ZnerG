<?php

use LaravelBook\Ardent\Ardent;

class Structure extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'structures';
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
		'name'							=> 'ASC',
	);

	public static $rules = array(
		'name'                  => 'required',
	);

	public $arraySearchFields = array('name', 'isVisible');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

	public static function updateStatus()
    {
		$modelData = self::lists('name', 'id');
		$dbName = DB::connection()->getDatabaseName();
		$list = Helper::getStructures($dbName, $modelData);
		if ($list)
			self::insert($list);
	}

}

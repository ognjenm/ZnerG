<?php

use LaravelBook\Ardent\Ardent;

class Workflow extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'workflows';
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

	public $arraySearchFields = array('name', 'description', 'isActive');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

}

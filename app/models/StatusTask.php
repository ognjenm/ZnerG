<?php

use LaravelBook\Ardent\Ardent;

class StatusTask extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'statusTasks';
	protected $softDelete = true;
	protected $guarded = array();

	public $fieldName = 'name';
	public $filters = array(
		'id_organization'				=> 'organizations',
	);
	public $filtersWhere = array(
		'id_organization'				=> null,
	);
	public $filtersTemp = array(
		'id_organization'				=> 'organizations',
	);
	public $wheres = array(
		'id_organization'				=> 'organizations',
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

}

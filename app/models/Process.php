<?php

use LaravelBook\Ardent\Ardent;

class Process extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'processes';
	protected $guarded = array();
	protected $softDelete = true;

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
		'name'							=> 'ASC',
	);

	public static $rules = array(
		'name' 				=> 'required',
		'id_organization' 	=> 'required',
		);

	public static $rulesDates = array(
		'startDate' 	=> 'date_format:"Y-m-d"',
		'endDate' 		=> 'date_format:"Y-m-d"',
	);

	public $arraySearchFields = array('name', 'description');

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

    public function campaign()
    {
    	return $this->belongsTo('Campaign', 'id_campaign', 'id');

    }
}


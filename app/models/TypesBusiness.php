<?php

use LaravelBook\Ardent\Ardent;

class TypesBusiness extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'typesBusinesses';
	protected $softDelete = true;
	protected $guarded = array();

	public $fieldName = 'name';
	public $filters = array(
		'id_campaign'				=> 'campaigns',
	);
	public $filtersWhere = array(
		'id_campaign'				=> null,
	);
	public $filtersTemp = array(
		'id_campaign'				=> 'campaigns',
	);
	public $wheres = array(
		'id_campaign'				=> 'campaigns',
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
    	return $this->belongsTo('Campaign', 'id_campaign', 'id');

    }
}

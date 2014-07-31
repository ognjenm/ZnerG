<?php

use LaravelBook\Ardent\Ardent;

class Location extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'locations';
	protected $softDelete = true;
	// protected $guarded = array();

	public $fieldName = 'phone';
	public $filters = array();
	public $filtersWhere = array();
	public $wheres = array();
	public $orderBy = array(
		'phone'				=> 'ASC',
	);

	public static $rules = array();

	public $arraySearchFields = array('phone', 'phoneAdditional');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

    public function address()
    {
    	return $this->belongsTo('Address', 'id_address', 'id');
    }

    public function business()
    {
    	return $this->belongsTo('Business', 'id_business', 'id');
    }

	public function getNameAttribute()
   	{
        return $this->attributes['phone'];
    }

}

<?php

use LaravelBook\Ardent\Ardent;

class Employee extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'employees';
	protected $softDelete = true;
	protected $guarded = array();

	public static $rules = array(
		'name'                  => 'required',
		'id_organization'       => 'required',
		'id_position'			=> 'required',
		'id_statusEmployee'		=> 'required',
		'firstName'				=> 'required',
		'lastName'				=> 'required',
		'startDate'				=> 'required',
	);

	public $arraySearchFields = array('firstName', 'lastName', 'alternativeId', 'driverLicense');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

    public function instances()
    {
    	return $this->hasMany('Instance');
    }

    public function campaigns()
    {
        return $this->hasMany('Campaign');
    }

    public function organization()
    {
    	return $this->belongsTo('Organization', 'id_organization', 'id');

    }

    public function getFullNameAttribute()
    {
        return $this->attributes['firstName'] . ' ' . $this->attributes['lastName'];
    }

}
        
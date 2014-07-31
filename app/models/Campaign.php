<?php

use LaravelBook\Ardent\Ardent;

class Campaign extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'campaigns';
	protected $softDelete = true;
	protected $guarded = array();

	public static $rules = array(
		'name'                  => 'required',
		'id_client'       => 'required',
		'id_position'			=> 'required',
	);

	public $arraySearchFields = array('name', 'isActive');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

    public function client()
    {
    	return $this->belongsTo('Client', 'id_client', 'id');

    }
}

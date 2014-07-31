<?php

use LaravelBook\Ardent\Ardent;

class DataType extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'dataTypes';
	protected $softDelete = true;
	protected $guarded = array();

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

}

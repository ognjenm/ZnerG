<?php

use LaravelBook\Ardent\Ardent;

class Team extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'teams';
	protected $softDelete = true;
	protected $guarded = array('startDate', 'endDate');

	public static $rules = array(
		'name'                  => 'required',
		'id_organization'       => 'required',
	);

	public static $rulesDates = array(
		'startDate' 			=> 'date_format:"Y-m-d"',
		'endDate' 				=> 'date_format:"Y-m-d"',
	);

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

}

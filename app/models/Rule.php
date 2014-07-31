<?php

use LaravelBook\Ardent\Ardent;

class Rule extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'rules';
	protected $guarded = array();

	public static $rules = array(
		'id_initialActivity'	=> 'required',
		'id_finalActivity'  	=> 'required',
		'id_typesRule'			=> 'required',
	);

	public $arraySearchFields = array('logic', 'message');

	public static function boot()
    {
        parent::boot();

	    // Setup event bindings...
		self::observe(new ModelObserver);
    }

}

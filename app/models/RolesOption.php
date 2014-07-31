<?php

use LaravelBook\Ardent\Ardent;

class RolesOption extends Eloquent {
	//public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	//public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'rolesOptions';
	protected $guarded = array();

	public static $rules = array(
		'id_role'        => 'required',
		'id_option'     => 'required',
	);

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
    }

}

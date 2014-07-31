<?php

use LaravelBook\Ardent\Ardent;

class RolesGroup extends Ardent {
	//public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	//public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'rolesGroups';
	protected $guarded = array();

	public static $rules = array(
		'id_role'        => 'required',
		'id_group'       => 'required',
	);

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
    }

}

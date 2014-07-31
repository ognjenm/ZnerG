<?php

use LaravelBook\Ardent\Ardent;

class UsersGroup extends Ardent {
	//public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	//public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'usersGroups';
	protected $guarded = array();

	public static $rules = array(
		'id_user'        => 'required',
		'id_group'       => 'required',
	);

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
    }

}

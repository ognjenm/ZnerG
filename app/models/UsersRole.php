<?php

use LaravelBook\Ardent\Ardent;

class UsersRole extends Ardent {
	//public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	//public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'usersRoles';
	protected $guarded = array();

	public static $rules = array(
		'id_user'       => 'required',
		'id_role'       => 'required',		
		'startDate' 	=> 'date_format:"Y-m-d"',
		'endDate' 		=> 'date_format:"Y-m-d"',
	);

	public static $rulesDates = array(
		'startDate' 	=> 'date_format:"Y-m-d"',
		'endDate' 		=> 'date_format:"Y-m-d"',
	);

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
    }

    public function user()
    {
    	return $this->belongsTo('User', 'id_user', 'id');

    }


}

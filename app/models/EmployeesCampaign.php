<?php

use LaravelBook\Ardent\Ardent;

class EmployeesCampaign extends Ardent {
	//public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	//public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'employeesCampaigns';
	protected $guarded = array();

	public static $rules = array(
		'id_employee'        => 'required',
		'id_campaign'       => 'required',
	);

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
    }

    public function campaigns()
    {
    	return $this->hasMany('Campaign');
    }

}

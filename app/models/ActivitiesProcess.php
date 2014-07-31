<?php

use LaravelBook\Ardent\Ardent;

class ActivitiesProcess extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'activitiesProcesses';
	protected $guarded = array();

	public static $rules = array(
		'name'					=> 'required',
		'id_process'  			=> 'required',
		'id_activity'			=> 'required',
		'id_typesNotification'	=> 'required',
	);

	public $arraySearchFields = array('name');

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

    public function activity()
    {
        return $this->belongsTo('Activity');
    }

    public function process()
    {
        return $this->belongsTo('Process');
    }
}

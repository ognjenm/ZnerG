<?php

use LaravelBook\Ardent\Ardent;

class Instance extends Eloquent {
	protected $table = 'instances';
	protected $softDelete = true;
	protected $guarded = array();

	public static $rules = array(
		'id_activitiesProcess'  => 'required',
		'id_employee'			=> 'required',
	);

	public $arraySearchFields = array('id', 'isActive');

	public static function boot()
    {
        parent::boot();

	    // Setup event bindings...
		self::observe(new ModelObserver);
    }

    public function activitiesProcess()
    {
    	return $this->belongsTo('ActivitiesProcess', 'id_activitiesProcess', 'id');

    }

    public function employee()
    {
    	return $this->belongsTo('Employee', 'id_employee', 'id');

    }

}

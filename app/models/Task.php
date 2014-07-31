<?php

use LaravelBook\Ardent\Ardent;

class Task extends Eloquent {
	protected $table = 'tasks';
	protected $softDelete = true;
	protected $guarded = array();

	public static $rules = array(
		'id_activitiesProcess'  => 'required',
		'id_employee'			=> 'required',
		'id_instance'			=> 'required',
		'id_statusTask'			=> 'required',
	);

	public $arraySearchFields = array('dueDate', 'duration', 'notes', 'summary', 'reference');

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

    public function statusTask()
    {
        return $this->belongsTo('StatusTask', 'id_statusTask', 'id');

    }

    public function employee()
    {
    	return $this->belongsTo('Employee', 'id_employee', 'id');

    }

    public function instance()
    {
    	return $this->belongsTo('Instance', 'id_instance', 'id');

    }

}

<?php

use LaravelBook\Ardent\Ardent;

class Client extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'clients';
	protected $softDelete = true;
	protected $guarded = array();

	public static $rules = array(
		'name'                  => 'required',
		'id_organization'       => 'required',
	);

	public $arraySearchFields = array('name', 'isActive');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

    public function organization()
    {
    	return $this->belongsTo('Organization', 'id_organization', 'id');

    }

    public function campaigns()
    {
    	return $this->hasMany('Campaign');
    }
}

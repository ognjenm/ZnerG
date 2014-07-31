<?php

use LaravelBook\Ardent\Ardent;

class Application extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'applications';
	protected $softDelete = true;
	protected $guarded = array();

	public static $rules = array(
		'name'                  => 'required',
		'id_typesApplication'   => 'required',
	);

	public $arraySearchFields = array('name', 'description', 'externalReference');

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

    public function typesApplication()
    {
    	return $this->belongsTo('TypesApplication', 'id_typesApplication', 'id');

    }
}

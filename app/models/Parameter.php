<?php

use LaravelBook\Ardent\Ardent;

class Parameter extends Ardent
{
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'parameters';
	protected $guarded = array();
	protected $softDelete = true;

	public static $rulesInsert = array(
		'name' => 'required|unique:parameters',
		'value' => 'required',
		'access' => 'required',
		'id_category' => 'required'
	);

	public static $rulesUpdate = array(
		'value' => 'required',
		'access' => 'required',
		'id_category' => 'required'
	);

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
        self::observe(new ModelObserver);

    }

/*	public function organizations()
	{
		return $this->belongsToMany('Organization', 'organizationParameters', 'id_organization', 'id_parameter')->withPivot('value');		
	}
*/
	public function categoryParameter()
	{
		return $this->belongsTo('CategoriesParameter', 'id_category', 'id');		
	}

}


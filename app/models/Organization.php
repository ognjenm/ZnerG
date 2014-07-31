<?php

use LaravelBook\Ardent\Ardent;

class Organization extends Ardent {
    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'organizations';
	protected $guarded = array();
	protected $softDelete = true;

    public $fieldName = 'name';
    public $filters = array(
    );
    public $filtersWhere = array(
    );
    public $filtersTemp = array(
    );
    public $wheres = array(
    );
    public $orderBy = array(
        'name'                          => 'ASC',
    );

    public static $rules = array(
        'name'                  => 'required',
        'shortName'             => 'required',
    );

    public $arraySearchFields = array('name', 'shortName', 'isActive', 'isSystem');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
        self::observe(new ModelObserver);

    }

    public function database()
    {
        return $this->belongsTo('Database', 'id_database', 'id');

    }

    public function parameters()
    {
        return $this->belongsToMany('Parameter', 'organizationParameters', 'id_organization', 'id_parameter')->withPivot('value');
    }

    public function clients()
    {
    	return $this->hasMany('Client');
    }

    public function users()
    {
        return $this->hasMany('User');
    }

    public function groups()
    {
    	return $this->hasMany('Group');
    }

    public function roles()
    {
        return $this->hasMany('Role');
    }

    public function processes()
    {
        return $this->hasMany('Process');
    }

    public function activities()
    {
    	return $this->hasMany('Activity');
    }

    public function metaDatas()
    {
        return $this->hasMany('MetaData');
    }

    public function employees()
    {
        return $this->hasMany('Employee');
    }

    public static function getDatabaseFromUser($user)
    {
        $organization = Organization::where('id', '=', $user->id_organization)
                                ->get()
                                ->first();
        return $organization->id_database;
    }


}

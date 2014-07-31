<?php

use LaravelBook\Ardent\Ardent;

class MenuItem extends Ardent {
	protected $table = 'menuItems';
	protected $guarded = array();
	protected $softDelete = true;

	public $fieldName = 'name';
	public $filters = array(
	);
	public $filtersWhere = array(
	);
	public $wheres = array(
	);
	public $orderBy = array(
		'name'							=> 'ASC',
	);

	public static $rules = array(
		'name' => 'required',
		);

	public $arraySearchFields = array('name');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
        self::observe(new ModelObserver);
    }

}

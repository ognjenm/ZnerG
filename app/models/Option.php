<?php

use LaravelBook\Ardent\Ardent;

class Option extends Ardent {
	protected $table = 'options';
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
		'version' => 'required',
		'link' => 'required',
		'startDate' => 'date_format:"Y-m-d"',
		'endDate' => 'date_format:"Y-m-d"',
		);

	public $arraySearchFields = array('name', 'description', 'link', 'isPublished', 'version');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
        self::observe(new ModelObserver);
    }

}

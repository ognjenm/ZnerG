<?php

use LaravelBook\Ardent\Ardent;

class Field extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'fields';
	protected $softDelete = true;
	protected $guarded = array();

	public $fieldName = 'name';
	public $filters = array(
		'id_organization'				=> 'organizations',
		'id_metaData'					=> 'metaDatas',
	);
	public $filtersWhere = array(
		'id_metaData'					=> array('id_organization'),
	);
	public $filtersTemp = array(
		'id_organization'				=> 'organizations',
		'id_metaData'					=> 'metaDatas',
	);
	public $wheres = array(
		'id_metaData'					=> 'metaDatas',
		'isSystem'						=> array('No'),
	);
	public $orderBy = array(
		'positionUI'					=> 'ASC',
	);

	public static $rules = array(
		'name'                  => 'required',
		'id_metaData'       	=> 'required',
	);

	public $arraySearchFields = array('name', 'description');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

    public function metaData()
    {
    	return $this->belongsTo('MetaData', 'id_metaData', 'id');

    }

    public function structure()
    {
    	return $this->belongsTo('Structure', 'id_structure', 'id');

    }

    public function dataType()
    {
    	return $this->belongsTo('DataType', 'id_dataType', 'id');

    }

    public static function createSystemFields($id_metaData, $audit)
    {
    	// We create the id field
		$field = new Field;

		$field->autoHydrateEntityFromInput = false;
		$field->forceEntityHydrationFromInput = false;
		$field->name = 'id';
		$field->id_metaData = $id_metaData;
		$field->isSystem = 'Yes';
		$field->isPk = 'Yes';
		$id_dataType = DataType::where('name', '=', 'INT')->first();
		if ($id_dataType)
			$id_dataType = $id_dataType['id'];
		$field->id_dataType = $id_dataType;

		$result = $field->save();

    	// We create the id_instance field
		$field = new Field;

		$field->autoHydrateEntityFromInput = false;
		$field->forceEntityHydrationFromInput = false;
		$field->name = 'id_instance';
		$field->id_metaData = $id_metaData;
		$field->isLinked = 'Yes';
		$field->isSystem = 'Yes';
		$field->isNullable = 'No';
		$id_dataType = DataType::where('name', '=', 'INT')->first();
		if ($id_dataType)
			$id_dataType = $id_dataType['id'];
		$field->id_dataType = $id_dataType;
		$id_structure = Structure::where('name', '=', 'instances')->first();
		if ($id_structure)
			$id_structure = $id_structure['id'];
		$field->id_structure = $id_structure;

		$result = $field->save();


    	// We create the id_activitiesProcess field
		$field = new Field;

		$field->autoHydrateEntityFromInput = false;
		$field->forceEntityHydrationFromInput = false;
		$field->name = 'id_activitiesProcess';
		$field->id_metaData = $id_metaData;
		$field->isLinked = 'Yes';
		$field->isSystem = 'Yes';
		$field->isNullable = 'No';
		$id_dataType = DataType::where('name', '=', 'INT')->first();
		if ($id_dataType)
			$id_dataType = $id_dataType['id'];
		$field->id_dataType = $id_dataType;
		$id_structure = Structure::where('name', '=', 'activitiesProcesses')->first();
		if ($id_structure)
			$id_structure = $id_structure['id'];
		$field->id_structure = $id_structure;

		$result = $field->save();

    	// We create the id_employee field
		$field = new Field;

		$field->autoHydrateEntityFromInput = false;
		$field->forceEntityHydrationFromInput = false;
		$field->name = 'id_employee';
		$field->id_metaData = $id_metaData;
		$field->isLinked = 'Yes';
		$field->isSystem = 'Yes';
		$field->isNullable = 'No';
		$id_dataType = DataType::where('name', '=', 'INT')->first();
		if ($id_dataType)
			$id_dataType = $id_dataType['id'];
		$field->id_dataType = $id_dataType;
		$id_structure = Structure::where('name', '=', 'employees')->first();
		if ($id_structure)
			$id_structure = $id_structure['id'];
		$field->id_structure = $id_structure;

		$result = $field->save();

    	// We create the id_employee field
		$field = new Field;

		$field->autoHydrateEntityFromInput = false;
		$field->forceEntityHydrationFromInput = false;
		$field->name = 'id_task';
		$field->id_metaData = $id_metaData;
		$field->isLinked = 'Yes';
		$field->isSystem = 'Yes';
		$field->isNullable = 'Yes';
		$id_dataType = DataType::where('name', '=', 'INT')->first();
		if ($id_dataType)
			$id_dataType = $id_dataType['id'];
		$field->id_dataType = $id_dataType;
		$id_structure = Structure::where('name', '=', 'tasks')->first();
		if ($id_structure)
			$id_structure = $id_structure['id'];
		$field->id_structure = $id_structure;

		$result = $field->save();

		if (!$result)
			return 0;

    	if ($audit == 'Yes')
    	{
    		//Creating Created_at field
			$field = new Field;
			$field->autoHydrateEntityFromInput = false;
			$field->forceEntityHydrationFromInput = false;
			$field->name = 'created_at';
			$field->id_metaData = $id_metaData;
			$field->isSystem = 'Yes';
			$field->isNullable = 'No';
			$field->default = '0000-00-00 00:00:00';
			$id_dataType = DataType::where('name', '=', 'TIMESTAMP')->first();
			if ($id_dataType)
				$id_dataType = $id_dataType['id'];
			$field->id_dataType = $id_dataType;

			$result = $field->save();

    		//Creating Updated_at field
			$field = new Field;
			$field->autoHydrateEntityFromInput = false;
			$field->forceEntityHydrationFromInput = false;
			$field->name = 'updated_at';
			$field->id_metaData = $id_metaData;
			$field->isSystem = 'Yes';
			$field->isNullable = 'No';
			$field->default = '0000-00-00 00:00:00';
			$id_dataType = DataType::where('name', '=', 'TIMESTAMP')->first();
			if ($id_dataType)
				$id_dataType = $id_dataType['id'];
			$field->id_dataType = $id_dataType;

			$result = $field->save();

    		//Creating Deleted_at field
			$field = new Field;
			$field->autoHydrateEntityFromInput = false;
			$field->forceEntityHydrationFromInput = false;
			$field->name = 'deleted_at';
			$field->id_metaData = $id_metaData;
			$field->isSystem = 'Yes';
			$field->isNullable = 'Yes';
			$id_dataType = DataType::where('name', '=', 'TIMESTAMP')->first();
			if ($id_dataType)
				$id_dataType = $id_dataType['id'];
			$field->id_dataType = $id_dataType;

			$result = $field->save();

    	}
    	return 1;
    }

    public static function deleteAuditFields($id_metaData)
    {
    	// Delete audit fields from the table

	}

}

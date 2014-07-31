<?php

class MetaDatasController extends ArdentController {

	public function __construct(MetaData $model)
	{
		$this->model = $model;
	}
		/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
		$this->model->updateStatus();

        return parent::index(); 
	}

	public function store()
	{
		$modelName = Session::get('modelName');	

		if ($this->model->save())
		{
			// We add the system fields
			$return = Field::createSystemFields($this->model->id, $this->model->audit);
			if ($return)
				return Redirect::route($modelName. '.edit', $this->model->id)
								->withInput();
			else
				return Redirect::route($modelName. '.create')
								->withInput()
								->with('message', trans('ui.couldntCreateSystemFields'));
		}
		else
			return Redirect::route($modelName. '.create')
				->withInput()
				->withErrors($this->model->errors());
	}

	public function update($id)
	{
		// If audit is 'No' and those fields exists, we drop them
		Field::deleteAuditFields($id);
				
        return parent::update($id); 
	}

	public function destroy($id)
	{
		$modelName = Session::get('modelName');	

		// See if the table has data 
		$structureName = '_data_' . $id;
		if (Schema::hasTable($structureName))
		{
			$numberRows = DB::table($structureName)->select('id')->get();
			// If there are records in the table, send message and exit
			if ($numberRows)
				return Redirect::route($modelName. '.index')
					->with('message', trans('ui.couldntDeleteBecauseDataExistent'));
		}
		// If audit is 'No' and those fields exists, we drop them
		Field::deleteAuditFields($id);

        return parent::destroy($id); 
	}

	public function generate()
	{
		$modelName = Session::get('modelName');	

		$id_metaData = Input::get('id');
		$this->model = $this->model->find($id_metaData);
		$tableName = '_data_' . $id_metaData;
		if (Schema::hasTable($tableName))
		{
			// Already exists
		}
		else
		{
			// Getting the list of non-system fields 
			$fields = Field::where('isActive', '=', 'Yes')
							->where('isSystem', '=', 'No')
							->where('id_metaData', '=', $id_metaData)
							->get();

			// If there are none, throw error
			if (!$fields->count())
				return Redirect::route($modelName. '.index')->with('message', trans('ui.thereAreNoFields'));

			// Cargamos todos los campos menos el PK
			$fields = Field::where('isActive', '=', 'Yes')
							->where('isPk', '=', 'No')
							->where('id_metaData', '=', $id_metaData)
							->orderBy('positionUI', 'ASC')
							->get();

			// First we create the pk field
			$pkFields = Field::where('isActive', '=', 'Yes')
							->where('isPk', '=', 'Yes')
							->where('id_metaData', '=', $id_metaData)
							->get();

			// Create the table
			Schema::create($tableName, function($table) use ($pkFields)
			{
				foreach($pkFields as $field)
				{
			    	$table->increments($field->name);
				}
			});

			// Add the fields
			foreach($fields as $field)
			{
				if ($field->isLinked == 'No')
				{
					Schema::table($tableName, function($table) use ($field)
					{
						$dataTypeName = DataType::where('id', '=', $field->id_dataType)->first()->name;
						switch ($dataTypeName)
						{
						    case 'INT':					    	
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->integer($field->name)->nullable()->default($field->default);
									else
										$table->integer($field->name)->nullable();
								}
								else
								{
									if ($field->default)
										$table->integer($field->name)->default($field->default);
									else
										$table->integer($field->name);
						        }
						        break;
						    case 'VARCHAR':
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->string($field->name, $field->length)->nullable()->default($field->default);
									else
										$table->string($field->name, $field->length)->nullable();
								}
								else
								{
									if ($field->default)
										$table->string($field->name, $field->length)->default($field->default);
									else
										$table->string($field->name, $field->length);
								}
						        break;
						    case 'TEXT':
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->text($field->name)->nullable()->default($field->default);
									else
										$table->text($field->name)->nullable();
								}
								else
								{
									if ($field->default)
										$table->text($field->name)->default($field->default);
									else
										$table->text($field->name);
								}
						        break;
						    case 'DATE':
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->date($field->name)->nullable()->default($field->default);
									else
										$table->date($field->name)->nullable();
								}
								else
								{
									if ($field->default)
										$table->date($field->name)->default($field->default);
									else
										$table->date($field->name);
								}
						        break;
						    case 'TINYINT':
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->tinyInteger($field->name)->nullable()->default($field->default);
									else
										$table->tinyInteger($field->name)->nullable();
								}
								else
								{
									if ($field->default)
										$table->tinyInteger($field->name)->default($field->default);
									else
										$table->tinyInteger($field->name);
								}
						        break;
						    case 'SMALLINT':
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->smallInteger($field->name)->nullable()->default($field->default);
									else
										$table->smallInteger($field->name)->nullable();
								}
								else
								{
									if ($field->default)
										$table->smallInteger($field->name)->default($field->default);
									else
										$table->smallInteger($field->name);
								}
						        break;
						    case 'BIGINT':
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->bigInteger($field->name)->nullable()->default($field->default);
									else
										$table->bigInteger($field->name)->nullable();
								}
								else
								{
									if ($field->default)
										$table->bigInteger($field->name)->default($field->default);
									else
										$table->bigInteger($field->name);
								}
						        break;
						    case 'DECIMAL':
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->decimal($field->name, $field->precision, $field->scale)->nullable()->default($field->default);
									else
										$table->decimal($field->name, $field->precision, $field->scale)->nullable();
								}
								else
								{
									if ($field->default)
										$table->decimal($field->name, $field->precision, $field->scale)->default($field->default);
									else
										$table->decimal($field->name, $field->precision, $field->scale);
								}
						        break;
						    case 'FLOAT':
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->float($field->name)->nullable()->default($field->default);
									else
										$table->float($field->name)->nullable();
								}
								else
								{
									if ($field->default)
										$table->float($field->name)->default($field->default);
									else
										$table->float($field->name);
								}
						        break;
						    case 'DOUBLE':								
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->double($field->name, $field->precision, $field->scale)->nullable()->default($field->default);
									else
										$table->double($field->name, $field->precision, $field->scale)->nullable();
								}
								else
								{
									if ($field->default)
										$table->double($field->name, $field->precision, $field->scale)->default($field->default);
									else
										$table->double($field->name, $field->precision, $field->scale);
								}
						        break;
						    case 'BOOLEAN':
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->boolean($field->name)->nullable()->default($field->default);
									else
										$table->boolean($field->name)->nullable();
								}
								else
								{
									if ($field->default)
										$table->boolean($field->name)->default($field->default);
									else
										$table->boolean($field->name);
								}
						        break;
						    case 'DATETIME':								
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->dateTime($field->name)->nullable()->default($field->default);
									else
										$table->dateTime($field->name)->nullable();
								}
								else
								{
									if ($field->default)
										$table->dateTime($field->name)->default($field->default);
									else
										$table->dateTime($field->name);
								}
						        break;
						    case 'TIMESTAMP':								
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->timestamp($field->name)->nullable()->default($field->default);
									else
										$table->timestamp($field->name)->nullable();
								}
								else
								{
									if ($field->default)
										$table->timestamp($field->name)->default($field->default);
									else
										$table->timestamp($field->name);
								}
						        break;
						    case 'CHAR':								
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->string($field->name, 1)->nullable()->default($field->default);
									else
										$table->string($field->name, 1)->nullable();
								}
								else
								{
									if ($field->default)
										$table->string($field->name, 1)->default($field->default);
									else
										$table->string($field->name, 1);
								}
						        break;
						    case 'BLOB':								
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->binary($field->name)->nullable()->default($field->default);
									else
										$table->binary($field->name)->nullable();
								}
								else
								{
									if ($field->default)
										$table->binary($field->name)->default($field->default);
									else
										$table->binary($field->name);
								}
						        break;
						    case 'ENUM':
						    	$arrayEnum = explode(',', $field->values);
						    	//var_dump($arrayEnum);
						    	//dd($field->values);
								if ($field->isNullable == 'Yes')
								{
									if ($field->default)
										$table->enum($field->name, $arrayEnum)->nullable()->default($field->default);
									else
										$table->enum($field->name, $arrayEnum)->nullable();
								}
								else
								{
									if ($field->default)
										$table->enum($field->name, $arrayEnum)->default($field->default);
									else
										$table->enum($field->name, $arrayEnum);
								}
						        break;
						}
					});
				}
				else
				{
					// These fields are linked to other structures / tables in the database
					Schema::table($tableName, function($table) use ($field)
					{
						$structureName = Structure::where('id', '=', $field->id_structure)->first()->name;
						if ($field->isNullable == 'Yes')
							$table->unsignedInteger($field->name)->nullable();
						else
							$table->unsignedInteger($field->name);
						// Link with foreign key
						$table->foreign($field->name)->references('id')->on($structureName)->onDelete('restrict');
					});
				}
			}
		}
		return Redirect::route($modelName. '.index');
	}
}

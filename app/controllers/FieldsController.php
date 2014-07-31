<?php

class FieldsController extends ArdentController {

	public function __construct(Field $model)
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
		if (Session::has('id_metaDataSelected'))
			$id_metaData = Session::get('id_metaDataSelected');
		else
		{
			$id_metaData = MetaData::where('id_organization', '=', Session::get('id_organization'))
									->where('isActive', '=', 'Yes')								
									->first();
			if ($id_metaData)
				$id_metaData = $id_metaData->id;
			else
				$id_metaData = null;

		    Session::put('id_metaData', $id_metaData);
		}
        return parent::index();
	}

	public function getSearch()
	{
		$id_metaData = Input::get('id_metaData');
	    Session::put('id_metaData', $id_metaData);


        return parent::getSearch();
	}

	public function create()
	{
		$isLinked = Input::get('isLinked');
		if ($isLinked)
			Session::put('isLinked', $isLinked);
		return parent::create();
	}

	public function createDetail()
	{
		$id_metaData = Session::get('id_metaData');
		// There is no single MetaData selected
		if ($id_metaData == 0)
		{
			$modelName = Session::get('modelName');	
			return Redirect::route($modelName. '.index')
								->with('message', trans('ui.youHaveToSelectMetaData'));
		}

		$isLinked = Session::get('isLinked');
		if (!$isLinked)
			$isLinked = 'No';

		$metaDataName = MetaData::where('id', '=', $id_metaData)->first()->name;

		$dataTypes = DataType::where('isActive', '=', 'Yes')
								->lists('name', 'id');

		$structures = Structure::where('isVisible', '=', 1)
								->lists('name', 'id');

        return parent::createDetail()->with('id_metaData', $id_metaData)
        						->with('dataTypes', $dataTypes)
        						->with('structures', $structures)
        						->with('metaDataName', $metaDataName)
        						->with('filter', $isLinked);
	}
	
	public function show($id)
	{
		$this->model = $this->model->find($id);
		$isLinked = $this->model->isLinked;

		$id_metaData = $this->model->id_metaData;

		$metaDataName = MetaData::where('id', '=', $id_metaData)->first()->name;

		$dataTypes = DataType::where('isActive', '=', 'Yes')
								->lists('name', 'id');

		$structures = Structure::where('isVisible', '=', 1)
								->lists('name', 'id');

        return parent::show($id)->with('id_metaData', $id_metaData)
        						->with('dataTypes', $dataTypes)
        						->with('structures', $structures)
        						->with('metaDataName', $metaDataName)
        						->with('filter', $isLinked);
	}

	public function edit($id)
	{
		$isLinked = Input::get('isLinked');
		if ($isLinked)
			Session::put('isLinked', $isLinked);
		return parent::edit($id);
	}

	public function editDetail()
	{
		$id = Session::get('id');
		$this->model = $this->model->find($id);
		$isLinked = Session::get('isLinked');
		if (!$isLinked)
			$isLinked = $this->model->isLinked;

		$id_metaData = $this->model->id_metaData;

		$metaDataName = MetaData::where('id', '=', $id_metaData)->first()->name;

		$dataTypes = DataType::where('isActive', '=', 'Yes')
								->lists('name', 'id');

		$structures = Structure::where('isVisible', '=', 1)
								->lists('name', 'id');

        return parent::editDetail()->with('id', $id)
        						->with('id_metaData', $id_metaData)
        						->with('dataTypes', $dataTypes)
        						->with('structures', $structures)
        						->with('metaDataName', $metaDataName)
        						->with('filter', $isLinked)
        						->with('id_field', $id);
	}

	public function store()
	{
		$modelName = Session::get('modelName');	

		$isLinked = Input::get('isLinked');

		$id_metaData = Session::get('id_metaData');

		$metaDataName = MetaData::where('id', '=', $id_metaData)->first()->name;

		$dataTypes = DataType::where('isActive', '=', 'Yes')
								->lists('name', 'id');

		$structures = Structure::where('isVisible', '=', 1)
								->lists('name', 'id');

		if ($this->model->save())
			return Redirect::route($modelName. '.edit', $this->model->id)
							->withInput();
		else
			return Redirect::route($modelName. '.create')
				->with('dataTypes', $dataTypes)
				->with('structures', $structures)
				->with('metaDataName', $metaDataName)
	     		->with('filter', $isLinked)
				->withInput()
   				->withErrors($this->model->errors());
	}

	public function update($id)
	{
		$modelName = Session::get('modelName');	

		$this->model = $this->model->find($id);
		// First save all
		$this->model->save();
		// Clean some not needed info
		$this->model->autoHydrateEntityFromInput = false;    // hydrates on new entries' validation
		$this->model->forceEntityHydrationFromInput = false; // hydrates whenever validation is called

		if ($this->model->isLinked == 'Yes')
		{
			$this->model->id_dataType = null;
			$this->model->length = null;
			$this->model->precision = null;
			$this->model->scale = null;
			$this->model->values = null;
			$this->model->default = null;
		}
		else
		{
			$this->model->id_structure = null;
		}

		if ($this->model->save())
			return Redirect::route($modelName. '.index');
		else
			return Redirect::route($modelName. '.edit', $id)
								->withInput()
								->withErrors($this->model->errors());
	}


}

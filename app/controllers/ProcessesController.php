<?php

class ProcessesController extends ArdentController {

	public function __construct(Process $model)
	{
		$this->model = $model;
	}

	public function createDetail()
	{
    	$id_organization = Session::get('id_organization');

		$metaDatas = MetaData::where('id_organization', '=', $id_organization)->lists('name', 'id');
		$activities = Activity::where('id_organization', '=', $id_organization)->lists('name', 'id');
		$typesProcesses = TypesProcess::where('id_organization', '=', $id_organization)->lists('name', 'id');

        return parent::createDetail()->with('metaDatas', $metaDatas)->with('activities', $activities)->with('typesProcesses', $typesProcesses)->with('id_organization', $id_organization);
	}

	public function createByOrganization()
	{
    	$id_organization = Input::get('id_organization');

		$metaDatas = MetaData::where('id_organization', '=', $id_organization)->lists('name', 'id');
		$activities = Activity::where('id_organization', '=', $id_organization)->lists('name', 'id');
		$typesProcesses = TypesProcess::where('id_organization', '=', $id_organization)->lists('name', 'id');

        return parent::createDetail()->with('metaDatas', $metaDatas)->with('activities', $activities)->with('typesProcesses', $typesProcesses)->with('id_organization', $id_organization);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$modelName = Session::get('modelName');	
		$input = array_except(Input::all(), '_method');

		if (!isset($input['startDate']) || $input['startDate'] == "")
			Input::merge(array('startDate' => null));

		if (!isset($input['endDate']) || $input['endDate'] == "")
			Input::merge(array('endDate' => null));

		$v = Validator::make($input, Process::$rulesDates);

		if ($v->passes())
			return parent::store();
		else
			return Redirect::route($modelName. '.create')
				->withInput()
				->withErrors($this->model->errors());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$modelName = Session::get('modelName');	
		$model = $this->model->find($id);
		if(is_null($model))
			return Redirect::route($modelName. '.index');
		$id_organization = $model->id_organization;

		$metaDatas = MetaData::where('id_organization', '=', $id_organization)->lists('name', 'id');
		$activities = Activity::where('id_organization', '=', $id_organization)->lists('name', 'id');
		$typesProcesses = TypesProcess::where('id_organization', '=', $id_organization)->lists('name', 'id');

		return parent::show($id)->with('metaDatas', $metaDatas)->with('activities', $activities)->with('typesProcesses', $typesProcesses)->with('id_organization', $id_organization);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editDetail()
	{
		$modelName = Session::get('modelName');	
		$id = Session::get('id');
		$model = $this->model->find($id);
		if(is_null($model))
			return Redirect::route($modelName. '.index');
		$id_organization = $model->id_organization;

		$metaDatas = MetaData::where('id_organization', '=', $id_organization)->lists('name', 'id');
		$activities = Activity::where('id_organization', '=', $id_organization)->lists('name', 'id');
		$typesProcesses = TypesProcess::where('id_organization', '=', $id_organization)->lists('name', 'id');
		$listActivities = Activity::where('id_organization', '=', $id_organization)->where('isActive', '=', 'Yes')->get();

		return parent::editDetail()->with('id', $id)
								->with('metaDatas', $metaDatas)
								->with('activities', $activities)
								->with('typesProcesses', $typesProcesses)
								->with('listActivities', $listActivities)
								->with('id_organization', $id_organization);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$modelName = Session::get('modelName');	
		$this->model = $this->model->find($id);
		$input = array_except(Input::all(), '_method');

		$class = get_class($this->model);	
		$v = Validator::make($input, $class::$rulesDates);

		if ($v->passes())
		{
			$model = $this->model->find($id);
			if (!isset($input['startDate']) || $input['startDate'] == "")
				Input::merge(array('startDate' => null));
				
			if (!isset($input['endDate']) || $input['endDate'] == "")
				Input::merge(array('endDate' => null));
			
			return parent::update($id);
		}		
		return Redirect::route($modelName. '.edit', $id)
							->withInput()
							->withErrors($this->model->errors());
	}

	public function assignActivities()
	{
		$modelName = Session::get('modelName');	
		$id = Input::get('id');
		return Redirect::route($modelName. '.edit', $id);
	}


}

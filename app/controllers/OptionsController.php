<?php

class OptionsController extends BaseController {

	protected $model;

	public function __construct(Option $model)
	{
		$this->model = $model;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$modelName = Session::get('modelName');	
		$tableName = $modelName;
		return View::make('options.create', compact('modelName', 'tableName'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$modelName = Session::get('modelName');	

		if (isset($input['startDate']) && $input['startDate'] != "")
		{
			$date = DateTime::createFromFormat('Y-m-d', $input['startDate']);
			$input['startDate'] = $date;
		}

		if (isset($input['endDate']) && $input['endDate'] != "")
		{
			$date = DateTime::createFromFormat('Y-m-d', $input['endDate']);
			$input['endDate'] = $date;
		}
		if (!isset($input['startDate']) || $input['startDate'] == "")
			$input['startDate'] = null;

		if (!isset($input['endDate']) || $input['endDate'] == "")
			$input['endDate'] = null;

		$v = Validator::make($input, Option::$rules);

		if ($v->passes())
		{
			$this->model->create($input);

			return Redirect::route($modelName. '.index');
		}
		return Redirect::route($modelName. '.create')
			->withInput()
			->withErrors($v);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$model = $this->model->findOrFail($id);
		$modelName = Session::get('modelName');	
		$tableName = $modelName;

        return View::make('options.show', compact('model', 'modelName', 'tableName'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$model = $this->model->find($id);
		$modelName = Session::get('modelName');	
		$tableName = $modelName;

		if(is_null($model))
		{
			return Redirect::route('options.index');
		}
        return View::make('options.edit', compact('model', 'modelName', 'tableName'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$modelName = Session::get('modelName');	

		$v = Validator::make($input, Option::$rules);

		if ($v->passes())
		{
			$model = $this->model->find($id);
			if (!isset($input['startDate']) || $input['startDate'] == "")
				$input['startDate'] = null;

			if (!isset($input['endDate']) || $input['endDate'] == "")
				$input['endDate'] = null;

			$model->update($input);

			return Redirect::route($modelName. '.index');
		}

		return Redirect::route($modelName. '.edit', $id)
			->withInput()
			->withErrors($v);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$modelName = Session::get('modelName');	
		$model = $this->model->find($id);
		if ($model)
		{
			$model->delete();
			return Redirect::route($modelName. '.index');
		}
		else
			return Redirect::route($modelName. '.index')->with('message', trans('ui.alreadyDeleted'));
	}

}


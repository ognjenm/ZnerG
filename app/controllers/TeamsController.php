<?php

class TeamsController extends BaseController {

	protected $model;

	public function __construct(Team $model)
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
		$input = "";		
		$modelName = Session::get('modelName');	
		$modelData = Team::where('id_organization', Session::get('id_organization'))->orderBy('name', 'ASC')->paginate(Session::get('_numRowsPagination'));
		Session::put('nestedRoutePath', $modelName. '.index');	
        return View::make($modelName . '.index', compact('modelName', 'modelData', 'input'));
	}

	/**
	 * Display a listing with search of the resource.
	 *
	 * @return Response
	 */

	public function getSearch()
	{
	    $input = Input::get('searchField');
		$modelName = Session::get('modelName');	
		$modelData = Team::whereNull('deleted_at')
					->where(function($query)
					{
					    $input = Input::get('searchField');
						$query->where('id_organization', Session::get('id_organization'))->where('name', 'LIKE', '%'.$input.'%');
					})
					->orderBy('name', 'ASC')->paginate(Session::get('_numRowsPagination'));
		Session::put('nestedRoutePath', $modelName. '.index');	
	
        return View::make($modelName . '.index', compact('modelName','modelData','input'));
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

        return View::make($modelName. '.create', compact('modelName', 'tableName'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->model->id_organization = Session::get('id_organization');
		$modelName = Session::get('modelName');	

		$input = array_except(Input::all(), '_method');
		$this->model->startDate = $input['startDate'];
		$this->model->endDate = $input['endDate'];
		$v = $this->model->validate(Team::$rulesDates, array());
		if (!$v)
			return Redirect::route($modelName. '.create')
				->withInput()
				->withErrors($this->model->errors());

		if ($input['startDate'] == "")
			$this->model->startDate = null;
		else
			$this->model->startDate = $input['startDate'];

		if ($input['endDate'] == "")
			$this->model->endDate = null;
		else
			$this->model->endDate = $input['endDate'];

		if ($this->model->save())
			return Redirect::route($modelName. '.edit', $this->model->id)
							->withInput();
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
		$tableName = $modelName;	
		$model = $this->model->findOrFail($id);

        return View::make($modelName. '.show', compact('model', 'modelName', 'tableName'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$modelName = Session::get('modelName');	
		$tableName = $modelName;	
		$model = $this->model->find($id);

		if(is_null($model))
			return Redirect::route($modelName. '.index');

        return View::make($modelName. '.edit', compact('model', 'modelName', 'tableName'));
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
		$this->model = Team::find($id);

		$input = array_except(Input::all(), '_method');
		$this->model->startDate = $input['startDate'];
		$this->model->endDate = $input['endDate'];
		$v = $this->model->validate(Team::$rulesDates, array());
		if (!$v)
			return Redirect::route($modelName. '.edit', $id)
								->withInput()
								->withErrors($this->model->errors());

		if ($input['startDate'] == "")
			$this->model->startDate = null;
		else
			$this->model->startDate = $input['startDate'];

		if ($input['endDate'] == "")
			$this->model->endDate = null;
		else
			$this->model->endDate = $input['endDate'];

		if ($this->model->save()) 
			return Redirect::route($modelName. '.index');
		else
			return Redirect::route($modelName. '.edit', $id)
								->withInput()
								->withErrors($this->model->errors());
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
		$record = $this->model->find($id);
		if ($record)
		{
			$record->delete();
			return Redirect::route($modelName. '.index');
		}
		else
			return Redirect::route($modelName. '.index')->with('message', trans('ui.alreadyDeleted'));
	}

}

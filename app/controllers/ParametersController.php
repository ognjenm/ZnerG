<?php

class ParametersController extends BaseController {

	/**
	 * Parameter Repository
	 *
	 * @var Parameter
	 */
	protected $model;

	public function __construct(Parameter $model)
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
		$modelData = DB::table('parameters')
      		->select('parameters.id as id', 'parameters.name as name','parameters.value as value','parameters.description as description','parameters.access as access','categoriesParameters.name as category')
      		->join('categoriesParameters','categoriesParameters.id', '=', 'parameters.id_category')
      		->whereNull('parameters.deleted_at')
      		->orderBy('categoriesParameters.order','ASC')
      		->orderBy('parameters.name','ASC')
      		->paginate(Session::get('_numRowsPagination'));
		Session::put('nestedRoutePath', $modelName. '.index');	

		return View::make($modelName . '.index', compact('modelData','input','modelName'));

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
		$modelData = DB::table('parameters')
      		->select('parameters.id as id', 'parameters.name as name','parameters.value as value','parameters.description as description','parameters.access as access','categoriesParameters.name as category')
      		->join('categoriesParameters','categoriesParameters.id', '=', 'parameters.id_category')
      		->whereNull('parameters.deleted_at')
			->where(function($query)
			{
			    $input = Input::get('searchField');
				$query->where('parameters.name', 'LIKE', '%'.$input.'%')
					->orWhere('parameters.description', 'LIKE', '%'.$input.'%')
					->orWhere('parameters.value', 'LIKE', '%'.$input.'%')
					->orWhere('parameters.access', 'LIKE', '%'.$input.'%')
					->orWhere('categoriesParameters.name', 'LIKE', '%'.$input.'%');
			})
      		->orderBy('categoriesParameters.order','ASC')
      		->orderBy('parameters.name','ASC')
      		->paginate(Session::get('_numRowsPagination'));

		return View::make($modelName . '.index', compact('modelData','input','modelName'));
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
		$categories = CategoryParameter::lists('name', 'id');

        return View::make($modelName. '.create', compact('modelName', 'tableName', 'categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$modelName = Session::get('modelName');	

		if ($this->model->save(Parameter::$rulesInsert, array()))
			return Redirect::route($modelName. '.index');
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
		$categories = CategoryParameter::lists('name', 'id');

        return View::make($modelName. '.show', compact('model', 'modelName', 'tableName', 'categories'));
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
			return Redirect::route($modelName. '.index')->with('message', trans('ui.recordNotAvailable'));;

		$categories = CategoryParameter::lists('name', 'id');

        return View::make($modelName. '.edit', compact('model', 'modelName', 'tableName', 'categories'));
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
		$this->model = Parameter::find($id);

		if ($this->model->save(Parameter::$rulesUpdate, array()))
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

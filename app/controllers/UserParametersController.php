<?php

class UserParametersController extends BaseController {

	/**
	 * Parameter Repository
	 *
	 * @var Parameter
	 */
	protected $model;

	public function __construct(UserParameter $model)
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
		$id_category = Input::get('id_category');
		if (!isset($id_category))
			$id_category = 0;
		$categories = CategoryParameter::orderBy('order', 'ASC')->get();
		$id_organization = Session::get('id_organization');
		$id_user = Auth::user()->id;
		$organizations = Organization::lists('name', 'id');

		$arrayAccess = array('User');
		$listParameterWithUsers = DB::table('parameters')
									->select('parameters.id')
							  		->leftjoin('userParameters','parameters.id', '=', 'userParameters.id_parameter')
									->leftjoin('categoriesParameters','parameters.id_category', '=', 'categoriesParameters.id')
							  		->whereNull('parameters.deleted_at')
							  		->whereIn('parameters.access', $arrayAccess)
							  		->where('userParameters.id_user', '=', $id_user)
							  		->lists('parameters.id');

		$modelDataNoUser = DB::table('parameters')
									->select('parameters.id as id',
											 'parameters.name as name',
											 'parameters.value as defaultValue',
											 DB::raw('null as value'),
											 'parameters.description as description',
											 'parameters.access as access',
											 'categoriesParameters.name as category',
											 'categoriesParameters.id as id_category')
									->leftjoin('categoriesParameters','parameters.id_category', '=', 'categoriesParameters.id')
							  		->whereNull('parameters.deleted_at')
									->where(function($query) use ($listParameterWithUsers)
									{
										if ($listParameterWithUsers)
											$query->whereNotIn('parameters.id', $listParameterWithUsers);
										else
											$query->where('parameters.id', '<>', 'parameters.id');
									})							  		
							  		->whereIn('parameters.access', $arrayAccess)
							  		->orderBy('name', 'ASC');

		$modelData = DB::table('parameters')
									->select('parameters.id as id',
											 'parameters.name as name',
											 'parameters.value as defaultValue',
											 'userParameters.value as value',
											 'parameters.description as description',
											 'parameters.access as access',
											 'categoriesParameters.name as category',
											 'categoriesParameters.id as id_category')
							  		->leftjoin('userParameters','parameters.id', '=', 'userParameters.id_parameter')
									->leftjoin('categoriesParameters','parameters.id_category', '=', 'categoriesParameters.id')
							  		->whereNull('parameters.deleted_at')
							  		->whereIn('parameters.access', $arrayAccess)
							  		->where('userParameters.id_user', '=', $id_user)
							  		->union($modelDataNoUser)
							  		->get();
		foreach ($modelData as $record)
		{
			$valueOrganization = DB::table('organizationParameters')
										->select('organizationParameters.value')
										->where('organizationParameters.id_organization', '=', $id_organization)
										->where('organizationParameters.id_parameter', '=', $record->id)
										->lists('organizationParameters.value');

			if (count($valueOrganization))
			{
				if ($valueOrganization[0] && $valueOrganization[0] != "")
					$record->defaultValue = $valueOrganization[0];
			}
		}


		return View::make($modelName . '.index', compact('modelData', 'categories', 'input', 'id_category', 'modelName', 'id_organization', 'organizations'));
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
		$id_organization = Session::get('id_organization');

		$id_category = Input::get('id_category');
		if (!isset($id_category))
			$id_category = 0;
		$categories = CategoryParameter::orderBy('order', 'ASC')->get();
		$id_user = Auth::user()->id;

		$organizations = Organization::lists('name', 'id');

		$arrayAccess = array('User');
		$listParameterWithUsers = DB::table('parameters')
									->select('parameters.id')
							  		->leftjoin('userParameters','parameters.id', '=', 'userParameters.id_parameter')
									->leftjoin('categoriesParameters','parameters.id_category', '=', 'categoriesParameters.id')
							  		->whereNull('parameters.deleted_at')
							  		->whereIn('parameters.access', $arrayAccess)
							  		->where('userParameters.id_user', '=', $id_user)
							  		->lists('parameters.id');

		$modelDataNoUser = DB::table('parameters')
									->select('parameters.id as id',
											 'parameters.name as name',
											 'parameters.value as defaultValue',
											 DB::raw('null as id_user'),
											 DB::raw('null as value'),
											 'parameters.description as description',
											 'parameters.access as access',
											 'categoriesParameters.name as category',
											 'categoriesParameters.id as id_category')
									->leftjoin('categoriesParameters','parameters.id_category', '=', 'categoriesParameters.id')
							  		->whereNull('parameters.deleted_at')
									->where(function($query) use ($listParameterWithUsers)
									{
										if ($listParameterWithUsers)
											$query->whereNotIn('parameters.id', $listParameterWithUsers);
										else
											$query->where('parameters.id', '<>', 'parameters.id');
									})							  		
							  		->whereIn('parameters.access', $arrayAccess)
									->where(function($query) use ($input)
										{
											$query->where('parameters.name', 'LIKE', '%'.$input.'%')
												->orWhere('parameters.description', 'LIKE', '%'.$input.'%')
												->orWhere('parameters.value', 'LIKE', '%'.$input.'%')
												->orWhere('parameters.access', 'LIKE', '%'.$input.'%')
												->orWhere('categoriesParameters.name', 'LIKE', '%'.$input.'%');
										})
							  		->orderBy('name', 'ASC');

		$modelData = DB::table('parameters')
									->select('parameters.id as id',
											 'parameters.name as name',
											 'parameters.value as defaultValue',
											 'userParameters.id_user as id_user',
											 'userParameters.value as value',
											 'parameters.description as description',
											 'parameters.access as access',
											 'categoriesParameters.name as category',
											 'categoriesParameters.id as id_category')
							  		->leftjoin('userParameters','parameters.id', '=', 'userParameters.id_parameter')
									->leftjoin('categoriesParameters','parameters.id_category', '=', 'categoriesParameters.id')
							  		->whereNull('parameters.deleted_at')
							  		->whereIn('parameters.access', $arrayAccess)
							  		->where('userParameters.id_user', '=', $id_user)
									->where(function($query) use ($input)
										{
											$query->where('parameters.name', 'LIKE', '%'.$input.'%')
												->orWhere('parameters.description', 'LIKE', '%'.$input.'%')
												->orWhere('parameters.value', 'LIKE', '%'.$input.'%')
												->orWhere('parameters.access', 'LIKE', '%'.$input.'%')
												->orWhere('categoriesParameters.name', 'LIKE', '%'.$input.'%');
										})
							  		->union($modelDataNoUser)
							  		->get();
		foreach ($modelData as $record)
		{
			$valueOrganization = DB::table('organizationParameters')
										->select('organizationParameters.value')
										->where('organizationParameters.id_organization', '=', $id_organization)
										->where('organizationParameters.id_parameter', '=', $record->id)
										->lists('organizationParameters.value');

			if (count($valueOrganization))
			{
				if ($valueOrganization[0] && $valueOrganization[0] != "")
					$record->defaultValue = $valueOrganization[0];
			}
		}

		return View::make($modelName . '.index', compact('modelData', 'categories', 'input', 'id_category', 'modelName', 'id_organization', 'organizations'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$modelName = Session::get('modelName');	

		$id_parameter = Input::get('id_parameter');
		$id_user = Auth::user()->id;		
		$id_category = Input::get('id_category');
		$value = Input::get('value');		

		$userParameter = UserParameter::where('id_parameter', '=' , $id_parameter)->where('id_user', '=', $id_user)->get();
		if ($userParameter->count())	
		{
			// Update
			$result = DB::table('userParameters')
	            ->where('id_parameter', $id_parameter)
            	->where('id_user', $id_user)
            	->update(array('value' => $value));
		}
		else
		{
			// Insert
			DB::table('userParameters')
				->insert(array('id_parameter' => $id_parameter, 'id_user' => $id_user, 'value' => $value));
		}			
		return Redirect::route($modelName . '.index', array('id_category' => $id_category));
	}
}

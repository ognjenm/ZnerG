<?php

class OrganizationParametersController extends BaseController {

	/**
	 * Parameter Repository
	 *
	 * @var Parameter
	 */
	protected $model;

	public function __construct(OrganizationParameter $model)
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
		$id_organization = Input::get('id_organization');
		if (!isset($id_organization))
			$id_organization = Session::get('id_organization');
		$id_user = Auth::user()->id;
		$organizations = Organization::lists('name', 'id');

		$arrayAccess = array('User', 'Organization');
		$listParameterWithOrganization = DB::table('parameters')
									->select('parameters.id')
							  		->leftjoin('organizationParameters','parameters.id', '=', 'organizationParameters.id_parameter')
									->leftjoin('categoriesParameters','parameters.id_category', '=', 'categoriesParameters.id')
							  		->whereNull('parameters.deleted_at')
							  		->whereIn('parameters.access', $arrayAccess)
							  		->where('organizationParameters.id_organization', '=', $id_organization)
							  		->lists('parameters.id');

		$modelDataNoOrganization = DB::table('parameters')
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
									->where(function($query) use ($listParameterWithOrganization)
									{
										if ($listParameterWithOrganization)
											$query->whereNotIn('parameters.id', $listParameterWithOrganization);
										else
											$query->where('parameters.id', '<>', 'parameters.id');
									})							  		
							  		->whereIn('parameters.access', $arrayAccess)
							  		->orderBy('name', 'ASC');

		$modelData = DB::table('parameters')
									->select('parameters.id as id',
											 'parameters.name as name',
											 'parameters.value as defaultValue',
											 'organizationParameters.value as value',
											 'parameters.description as description',
											 'parameters.access as access',
											 'categoriesParameters.name as category',
											 'categoriesParameters.id as id_category')
							  		->leftjoin('organizationParameters','parameters.id', '=', 'organizationParameters.id_parameter')
									->leftjoin('categoriesParameters','parameters.id_category', '=', 'categoriesParameters.id')
							  		->whereNull('parameters.deleted_at')
							  		->whereIn('parameters.access', $arrayAccess)
							  		->where('organizationParameters.id_organization', '=', $id_organization)
							  		->union($modelDataNoOrganization)
							  		->get();

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
    	$id_organization = Input::get('id_organization');

		$id_category = Input::get('id_category');
		if (!isset($id_category))
			$id_category = 0;
		$categories = CategoryParameter::orderBy('order', 'ASC')->get();
		$id_user = Auth::user()->id;

		$organizations = Organization::lists('name', 'id');

		$arrayAccess = array('User', 'Organization');
		$listParameterWithOrganization = DB::table('parameters')
									->select('parameters.id')
							  		->leftjoin('organizationParameters','parameters.id', '=', 'organizationParameters.id_parameter')
									->leftjoin('categoriesParameters','parameters.id_category', '=', 'categoriesParameters.id')
							  		->whereNull('parameters.deleted_at')
							  		->whereIn('parameters.access', $arrayAccess)
							  		->where('organizationParameters.id_organization', '=', $id_organization)
							  		->lists('parameters.id');

		$modelDataNoOrganization = DB::table('parameters')
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
									->where(function($query) use ($listParameterWithOrganization)
									{
										if ($listParameterWithOrganization)
											$query->whereNotIn('parameters.id', $listParameterWithOrganization);
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
											 'organizationParameters.value as value',
											 'parameters.description as description',
											 'parameters.access as access',
											 'categoriesParameters.name as category',
											 'categoriesParameters.id as id_category')
							  		->leftjoin('organizationParameters','parameters.id', '=', 'organizationParameters.id_parameter')
									->leftjoin('categoriesParameters','parameters.id_category', '=', 'categoriesParameters.id')
							  		->whereNull('parameters.deleted_at')
							  		->whereIn('parameters.access', $arrayAccess)
							  		->where('organizationParameters.id_organization', '=', $id_organization)
									->where(function($query) use ($input)
									{
										$query->where('parameters.name', 'LIKE', '%'.$input.'%')
											->orWhere('parameters.description', 'LIKE', '%'.$input.'%')
											->orWhere('parameters.value', 'LIKE', '%'.$input.'%')
											->orWhere('parameters.access', 'LIKE', '%'.$input.'%')
											->orWhere('categoriesParameters.name', 'LIKE', '%'.$input.'%');
									})
							  		->union($modelDataNoOrganization)
							  		->get();

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
		$id_organization = Input::get('id_organization');
		$id_category = Input::get('id_category');
		$value = Input::get('value');		

    	//dd($id_organization);

		$organizationParameter = OrganizationParameter::where('id_parameter', '=' , $id_parameter)->where('id_organization', '=', $id_organization)->get();
		if ($organizationParameter->count())	
		{
			// Update
			DB::table('organizationParameters')
	            ->where('id_parameter', $id_parameter)
            	->where('id_organization', $id_organization)
            	->update(array('value' => $value));
		}
		else
		{
			// Insert
			DB::table('organizationParameters')
				->insert(array('id_parameter' => $id_parameter, 'id_organization' => $id_organization, 'value' => $value));
		}			
		return Redirect::route($modelName . '.index', array('id_category' => $id_category, 'id_organization' => $id_organization));
	}


}

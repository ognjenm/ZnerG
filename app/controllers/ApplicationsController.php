<?php

class ApplicationsController extends ArdentController {

	public function __construct(Application $model)
	{
		$this->model = $model;
	}

	public function index()
	{
		$modelName = Session::get('modelName');	
	    $tableName = $modelData;

	    $input = Input::get('searchField');
	    if (!$input)
			$input = "";
		$id_organization = Session::get('id_organizationSelected');		
		if (!$id_organization)
			$id_organization = Session::get('id_organization');

		// Pull all the Organizations
		if (Auth::user()->isSystem = 'Yes' && Auth::user()->id_organization == 1)
			$organizations = Organization::lists('name', 'id');
		else
			$organizations = array();

		$id_metaData = MetaData::where('id_organization', '=', $id_organization)
								->where('isActive', '=', 'Yes')								
								->first();
		if ($id_metaData)
			$id_metaData = $id_metaData->id;
		else
			$id_metaData = null;

	    Session::put('id_metaData', $id_metaData);

		$metaDatas = MetaData::where('id_organization', '=', $id_organization)
								->where('isActive', '=', 'Yes')
								->lists('name','id');

		$modelData = $this->model->whereNull($this->model->getTable().'.deleted_at')
								->where('id_metaData', '=', $id_metaData)
								->where('isActive', '=', 'Yes')
								->orderBy('name', 'ASC')
								->paginate(Session::get('_numRowsPagination'));

        return View::make($modelName. '.index', compact('modelName', 'modelData', 'tableName','organizations', 'input', 'id_organization', 'id_metaData', 'metaDatas'));
	}

	public function getSearch()
	{
		$modelName = Session::get('modelName');	
	    $tableName = $modelData;

	    $input = Input::get('searchField');
	    if (!$input)
			$input = "";
		$id_organization = Input::get('id_organization');
		Session::put('id_organizationSelected', $id_organization);

		// Pull all the Organizations
		if (Auth::user()->isSystem = 'Yes' && Auth::user()->id_organization == 1)
			$organizations = Organization::lists('name', 'id');
		else
			$organizations = array();

	    $id_metaData = Input::get('id_metaData');
	    if (!$id_metaData)
	    {
			$id_metaData = MetaData::where('id_organization', '=', $id_organization)
									->where('isActive', '=', 'Yes')								
									->first();
			if ($id_metaData)
				$id_metaData = $id_metaData->id;
			else
				$id_metaData = null;
	    }
	    Session::put('id_metaData', $id_metaData);

		$metaDatas = MetaData::where('id_organization', '=', $id_organization)
								->where('isActive', '=', 'Yes')
								->lists('name','id');

		$modelData = $this->model->whereNull($this->model->getTable().'.deleted_at')
								->where('id_metaData', '=', $id_metaData)
								->where('isActive', '=', 'Yes')
								->orderBy('name', 'ASC')
								->paginate(Session::get('_numRowsPagination'));

        return View::make($modelName. '.index', compact('modelName', 'modelData', 'tableName', 'organizations', 'input', 'id_organization', 'id_metaData', 'metaDatas'));
	}

	public function create()
	{
		$id_metaData = Session::get('id_metaData');

		$id_typesApplication = Session::get('filter');
		if (!$id_typesApplication)
		{
			$id_typesApplication = Input::get('id_typesApplication');
		}

		$metaDataName = MetaData::where('id', '=', $id_metaData)->first()->name;

		$typesApplicationName = TypesApplication::where('id', '=', $id_typesApplication)->first();
		$typesApplicationName = $typesApplicationName['name'];

		$typesApplications = TypesApplication::where('isActive', '=', 'Yes')
								->lists('name', 'id');

        return parent::create()->with('id_metaData', $id_metaData)
        						->with('typesApplicationName', $typesApplicationName)
        						->with('typesApplications', $typesApplications)
        						->with('metaDataName', $metaDataName)
	       						->with('filter', $id_typesApplication);
	}

	public function show($id)
	{
		$id_metaData = Session::get('id_metaData');

		$this->model = $this->model->find($id);
		$id_typesApplication = $this->model->id_typesApplication;

		$metaDataName = MetaData::where('id', '=', $id_metaData)->first()->name;

		$typesApplicationName = TypesApplication::where('id', '=', $id_typesApplication)->first();
		$typesApplicationName = $typesApplicationName['name'];

		$typesApplications = TypesApplication::where('isActive', '=', 'Yes')
								->lists('name', 'id');

        return parent::show($id)->with('id_metaData', $id_metaData)
        						->with('typesApplicationName', $typesApplicationName)
        						->with('typesApplications', $typesApplications)
        						->with('metaDataName', $metaDataName)
	       						->with('filter', $id_typesApplication);
	}

	public function edit($id)
	{
		$id_metaData = Session::get('id_metaData');

		$id_typesApplication = Session::get('filter');
		if (!$id_typesApplication)
		{
			$id_typesApplication = Input::get('id_typesApplication');
			if (!$id_typesApplication)
			{
				$this->model = $this->model->find($id);
				$id_typesApplication = $this->model->id_typesApplication;
			}				
		}

		$metaDataName = MetaData::where('id', '=', $id_metaData)->first()->name;

		$typesApplicationName = TypesApplication::where('id', '=', $id_typesApplication)->first();
		$typesApplicationName = $typesApplicationName['name'];

		$typesApplications = TypesApplication::where('isActive', '=', 'Yes')
								->lists('name', 'id');

		$listFields = Field::where('id_metaData', '=', $id_metaData)
							->where('isActive', '=', 'Yes')
							->where('isSystem', '=', 'No')
							->get();

        return parent::edit($id)->with('id_metaData', $id_metaData)
        						->with('typesApplicationName', $typesApplicationName)
        						->with('typesApplications', $typesApplications)
        						->with('listFields', $listFields)
        						->with('metaDataName', $metaDataName)
	       						->with('filter', $id_typesApplication)
       							->with('id_field', $id);
	}

}

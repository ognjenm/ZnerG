<?php

class TasksController extends BaseController {

	public function __construct(Task $model)
	{
		$this->model = $model;
	}

	public function index()
	{
		$modelName = Session::get('modelName');	

		Session::forget('instanceData');

		if (Session::has('searchField'))
			$input = Session::get('searchField');
		else
			$input = "";

		if (Auth::user()->id == 1)
		{
			$id_organization = Session::get('id_organizationSelected');		
			if (!$id_organization)
				$id_organization = Session::get('id_organization');
		}
		else
		{
			$id_organization = Auth::user()->id_organization;
			Session::put('id_organization', $id_organization);
		}

		// Pull all the Organizations
		if (Auth::user()->isSystem = 'Yes' && Auth::user()->id_organization == 1)
		{
			$organizations = Organization::lists('name', 'id');
			$arrayTemp = array('0'=>'All Organizations');
			$organizations = $arrayTemp + $organizations;
		}
		else
			$organizations = array();

		// Pull all the campaigns for the id_organization selected
		$campaigns = Helper::loadCampaigns(Auth::user()->id_employee, 4, 1);
		$arrayTemp = array('0'=>'All Campaigns');
		$campaigns = $arrayTemp + $campaigns;
		$id_campaign = Session::get('id_campaignSelected');
		if (!$id_campaign)
		{
			reset($campaigns);
			$id_campaign = key($campaigns);
		}

		// Collaborators
		$collaborators = Helper::loadCollaborators(Auth::user()->id_employee, 4, 1);
		if (count($collaborators) > 1)
		{
			$id_employee = Session::get('id_employeeSelected');		
			if (!$id_employee)
				$id_employee = Auth::user()->id_employee;
			else
				$id_employee = 0;
		}
		else
			$id_employee = Auth::user()->id_employee;
	
		// Activities
		$initialActivities = array();
		$initialActivities = Helper::loadInitialActivities(Auth::user()->id_employee);
		Session::put('initialActivities', $initialActivities);

		// We add All Employees option to the dropbox
		$arrayTemp = array('0'=>'All Employees');
		$collaborators = $arrayTemp + $collaborators;

		$task = new Task;
		$arraySearchFields = $task->arraySearchFields;		

		$arrayTemp = array('0'=>'All Status');
		$statusTasks = StatusTask::where('isActive', '=', 'Yes')
									->lists('name', 'id');

		$statusTasks = $arrayTemp + $statusTasks;
		if (Session::has('id_statusTask'))
			$id_statusTask = Session::get('id_statusTask');
		else
			$id_statusTask = 1;

		$arrayTemp = array('0'=>'All Activities');
		$activities = DB::table('activities')
								->select('activities.name as name', 'activitiesProcesses.id as id')
								->join('activitiesProcesses', 'activitiesProcesses.id_activity', '=', 'activities.id')
								->where('activities.isActive', '=', 'Yes')
								->where('activities.isSystem', '=', 'No')
								->whereNull('activities.deleted_at')
								->lists('name', 'id');

		$activities = $arrayTemp + $activities;
		if (Session::has('id_activitiesProcess'))
			$id_activitiesProcess = Session::get('id_activitiesProcess');
		else
			$id_activitiesProcess = 1;


		$days = array(
			'0' => trans('ui.all'),
			'1' => '1 day',
			'3' => '3 days',
			'7' => '7 days',
			'30' => '30 days');

		if (Session::has('id_day'))
			$id_day = Session::get('id_day');
		else
			$id_day = 1;

		$to = new DateTime();
		date_add($to, date_interval_create_from_date_string($id_day . ' days'));
		$to = new DateTime(date_format($to, 'Y-m-d'));

		$modelData = $this->model->select('tasks.id', DB::raw("CASE WHEN activitiesProcesses.id_activity = processes.id_initialActivity THEN 'Yes' ELSE 'No' END as isFirstActivity"), DB::raw('DATE_FORMAT(least(coalesce(dueDate, expirationDate), coalesce(expirationDate,dueDate)), "%Y-%m-%d %H:%i") as dueDate'), DB::raw("CASE WHEN dueDate < now() THEN 1 WHEN date(dueDate) = date(now()) THEN 2 ELSE 0 END as isUrgent"), 'tasks.notes', 'tasks.summary', 'tasks.reference', 'tasks.id_activitiesProcess', 'tasks.id_employee', 'tasks.id_statusTask')
								->join('instances', 'tasks.id_instance', '=', 'instances.id')
								->join('activitiesProcesses', 'tasks.id_activitiesProcess', '=', 'activitiesProcesses.id')
								->join('processes', 'processes.id', '=', 'activitiesProcesses.id_process');
		if ($id_activitiesProcess)
			$modelData = $modelData->where('tasks.id_activitiesProcess', '=', $id_activitiesProcess);

		if ($id_statusTask)
			$modelData = $modelData->where('tasks.id_statusTask', '=', $id_statusTask);

		if ($id_day)
			$modelData = $modelData->where(function($query) use ($to)
								{
									$query->where('tasks.dueDate', '<=', $to)
											->orWhere('tasks.expirationDate', '<=', $to)
											->orWhereRaw(DB::raw('least(coalesce(dueDate, expirationDate), coalesce(expirationDate,dueDate)) IS NULL'));
									});

		if (Session::has('mapFlag'))
		{
			$mapFlag = Session::get('mapFlag');
		}
		else
		{
			$mapFlag = 'false';
			Session::put('mapFlag', $mapFlag);
		}

		$modelData = $modelData->where(function($query) use ($id_employee)
								{
									if ($id_employee > 0)
										$query->where('tasks.id_employee', '=', $id_employee);
								})
								->where(function($query) use ($id_organization)
								{
									if ($id_organization > 0)
										$query->where('processes.id_organization', '=', $id_organization);
								})
								->where(function($query) use ($id_campaign)
								{
									if ($id_campaign > 0)
										$query->where('processes.id_campaign', '=', $id_campaign);
								})
								->where(function($query) use ($input, $arraySearchFields, $modelName)
								{
									$query->where('processes.name', 'LIKE', '%'.$input.'%');
									foreach ($arraySearchFields as $term)
									{
										if ($term != 'name')
											$query->orWhere('tasks.' . $term, 'LIKE', '%'.$input.'%');
									}
								})
								//->orderBy(DB::raw('dueDate IS NULL'))
								->orderBy(DB::raw('dueDate'), 'ASC')
								->orderBy('tasks.id', 'DSC');

		$modelData = $modelData->paginate(Session::get('_numRowsPagination'));
		$id_tab = 2;
        return View::make($modelName. '.index', compact('modelName', 'modelData', 'organizations', 'input', 'id_organization', 'id_employee', 'collaborators', 'id_campaign', 'campaigns', 'initialActivities', 'id_tab', 'days', 'id_day', 'statusTasks', 'id_statusTask', 'activities', 'id_activitiesProcess', 'mapFlag'));
	}

	public function getSearch()
	{
		$modelName = Session::get('modelName');	

		Session::forget('instanceData');
	    $input = Input::get('searchField');
	    if (!$input)
			$input = "";
		Session::put('searchField', $input);

		if (Auth::user()->id == 1)
		{
			$id_organization = Session::get('id_organizationSelected');		
			if (!$id_organization)
				$id_organization = Session::get('id_organization');
		}
		else
		{
			$id_organization = Auth::user()->id_organization;
			Session::put('id_organization', $id_organization);
		}

		// Pull all the Organizations
		if (Auth::user()->isSystem = 'Yes' && Auth::user()->id_organization == 1)
		{
			$organizations = Organization::lists('name', 'id');
			$arrayTemp = array('0'=>'All Organizations');
			$organizations = $arrayTemp + $organizations;
		}
		else
			$organizations = array();

		// Pull all the campaigns for the id_organization selected
		$campaigns = Helper::loadCampaigns(Auth::user()->id_employee, 4, 1);
		$arrayTemp = array('0'=>'All Campaigns');
		$campaigns = $arrayTemp + $campaigns;
		if (Input::has('id_campaign'))
			$id_campaign = Input::get('id_campaign');
		else
			$id_campaign = 0;
		Session::put('id_campaignSelected', $id_campaign);

		$collaborators = Helper::loadCollaborators(Auth::user()->id_employee, 4, 1);
		if (Input::has('id_employee'))
			$id_employee = Input::get('id_employee');
		else
			$id_employee = Auth::user()->id_employee;
		
		Session::put('id_employeeSelected', $id_employee);

		// Activities
		$initialActivities = array();
		$initialActivities = Helper::loadInitialActivities(Auth::user()->id_employee);
		Session::put('initialActivities', $initialActivities);

		// We add All Employees option to the dropbox
		$arrayTemp = array('0'=>'All Employees');
		$collaborators = $arrayTemp + $collaborators;

		$task = new Task;
		$arraySearchFields = $task->arraySearchFields;		

		$arrayTemp = array('0'=>'All Status');
		$statusTasks = StatusTask::where('isActive', '=', 'Yes')
									->lists('name', 'id');

		$statusTasks = $arrayTemp + $statusTasks;

		$id_statusTask = Input::get('id_statusTask');
		Session::put('id_statusTask', $id_statusTask);

		$arrayTemp = array('0'=>'All Activities');
		$activities = DB::table('activities')
								->select('activities.name as name', 'activitiesProcesses.id as id')
								->join('activitiesProcesses', 'activitiesProcesses.id_activity', '=', 'activities.id')
								->where('activities.isActive', '=', 'Yes')
								->where('activities.isSystem', '=', 'No')
								->whereNull('activities.deleted_at')
								->lists('name', 'id');

		$activities = $arrayTemp + $activities;
		$id_activitiesProcess = Input::get('id_activitiesProcess');
		Session::put('id_activitiesProcess', $id_activitiesProcess);

		$days = array(
			'0' => trans('ui.all'),
			'1' => '1 day',
			'3' => '3 days',
			'7' => '7 days',
			'30' => '30 days');

		$id_day = Input::get('id_day');
		Session::put('id_day', $id_day);

		if ($id_day)
		{
			$to = new DateTime();
			date_add($to, date_interval_create_from_date_string($id_day . ' days'));
			$to = new DateTime(date_format($to, 'Y-m-d'));
		}

		if (Session::has('mapFlag'))
		{
			$mapFlag = Session::get('mapFlag');
		}
		else
		{
			$mapFlag = 'false';
			Session::put('mapFlag', $mapFlag);
		}

		$modelData = $this->model->select('tasks.id',  DB::raw('DATE_FORMAT(least(coalesce(dueDate, expirationDate), coalesce(expirationDate,dueDate)), "%Y-%m-%d %H:%i") as dueDate'), DB::raw("CASE WHEN dueDate < now() THEN 1 WHEN date(dueDate) = date(now()) THEN 2 ELSE 0 END as isUrgent"), 'tasks.notes', 'tasks.summary', 'tasks.reference', 'tasks.id_activitiesProcess', 'tasks.id_employee', 'tasks.id_statusTask')
								->join('instances', 'tasks.id_instance', '=', 'instances.id')
								->join('activitiesProcesses', 'tasks.id_activitiesProcess', '=', 'activitiesProcesses.id')
								->join('processes', 'processes.id', '=', 'activitiesProcesses.id_process');

		if ($id_activitiesProcess)
			$modelData = $modelData->where('tasks.id_activitiesProcess', '=', $id_activitiesProcess);

		if ($id_statusTask)
			$modelData = $modelData->where('tasks.id_statusTask', '=', $id_statusTask);

		if ($id_day)
			$modelData = $modelData->where(function($query) use ($to)
								{
									$query->where('tasks.dueDate', '<=', $to)
											->orWhere('tasks.expirationDate', '<=', $to)
											->orWhereRaw(DB::raw('least(coalesce(dueDate, expirationDate), coalesce(expirationDate,dueDate)) IS NULL'));
									});

		$modelData = $modelData->where(function($query) use ($id_employee)
								{
									if ($id_employee > 0)
										$query->where('tasks.id_employee', '=', $id_employee);
								})
								->where(function($query) use ($id_organization)
								{
									if ($id_organization > 0)
										$query->where('processes.id_organization', '=', $id_organization);
								})
								->where(function($query) use ($id_campaign)
								{
									if ($id_campaign > 0)
										$query->where('processes.id_campaign', '=', $id_campaign);
								})
								->where(function($query) use ($input, $arraySearchFields, $modelName)
								{
									$query->where('processes.name', 'LIKE', '%'.$input.'%');
									foreach ($arraySearchFields as $term)
									{
										if ($term != 'name')
											$query->orWhere('tasks.' . $term, 'LIKE', '%'.$input.'%');
									}
								})
								//->orderBy(DB::raw('tasks.dueDate IS NULL'))
								->orderBy(DB::raw('dueDate'), 'ASC')
								->orderBy('tasks.id', 'DSC')
								->paginate(Session::get('_numRowsPagination'));
		$id_tab = 2;

        return View::make($modelName. '.index', compact('modelName', 'modelData', 'organizations', 'input', 'id_organization', 'id_employee', 'collaborators', 'id_campaign', 'campaigns', 'initialActivities', 'id_tab', 'days', 'id_day', 'statusTasks', 'id_statusTask', 'activities', 'id_activitiesProcess', 'mapFlag'));
  	}

	public function create()
	{
		$modelName = Session::get('modelName');	
		$lat = Input::get('lat');
		$lon = Input::get('lon');

		Session::put('lat', $lat);
		Session::put('lon', $lon);

		$id_activitiesProcess = Input::get('id_activitiesProcess');
		if (!$id_activitiesProcess)
		{
			if (!Session::has('id_activitiesProcess'))
			{
				return Redirect::route($modelName . '.index')
								->withInput()
								->with('message', trans('ui.couldntCreateTask'));
			}
			else
				$id_activitiesProcess = Session::get('id_activitiesProcess');
		}
		else
			Session::put('id_activitiesProcess', $id_activitiesProcess);

		$id_process = ActivitiesProcess::where('id', '=', $id_activitiesProcess)
										->first()->id_process;

		if ($id_process)
			$id_campaign = Process::where('id', '=', $id_process)
									->first()->id_campaign;

		if ($id_campaign)
		{
			Session::put('id_campaign', $id_campaign);
			return parent::create()->withInput(Session::get('instanceData'));;
		}
		else
			return Redirect::route($modelName . '.index')
							->withInput()
							->with('message', trans('ui.couldntCreateTask'));
	}

	public function createRelated()
	{
		if (Input::has('id_structure'))
		{
			$lat = Input::get('lat');
			$lon = Input::get('lon');
			Session::put('lat', $lat);
			Session::put('lon', $lon);

			Session::put('instanceData', array_except(Input::all(), '_method'));
			$id_structure = Input::get('id_structure');
			$mode = Input::get('mode');
			$structure = Structure::where('id', '=', $id_structure)
						->first();	
			$nameStructure = $structure->name;
			Session::put('nestedRoute', 'tasks.' . $mode);
			return Redirect::to($nameStructure . '/createDetail')->with('nestedCall', 'Yes');
		}
	}

	public function editRelated()
	{
		if (Input::has('id_structure'))
		{
			$id = Input::get('fieldValue');
			Session::put('instanceData', array_except(Input::all(), '_method'));
			$id_structure = Input::get('id_structure');
			$structure = Structure::where('id', '=', $id_structure)
						->first();	
			$nameStructure = $structure->name;
			$mode = Input::get('mode');
			Session::put('nestedRoute', 'tasks.' . $mode);
			return Redirect::to($nameStructure . '/editDetail')->with('id', $id)
																->with('nestedCall', 'Yes')
																->with('id_tab', 1);
		}
	}

	public function destroyRelated()
	{
		if (Input::has('id_structure'))
		{
			$modelName = Session::get('modelName');	
			$id = Input::get('fieldValue');
			$id_field = Input::get('id_field');
			$id_structure = Input::get('id_structure');
			$structure = Structure::where('id', '=', $id_structure)->first();
			$nameStructure = $structure->name;

			// we prepare to delete the information of the field just entered
			$input = Input::all();
			$id_fieldName = 'id_' . str_singular($nameStructure);
			$input[$id_fieldName] = '';
			$input[$nameStructure] = '';
			// then we find put what other fields to delete that depend on this one.
			// $field = Field::where('id', '=', $id_field)->first();
			// $id_metaData = $field->id_metaData;
			$id_metaData = $input['id_metaData'];
			Helper::deleteDependent($id_fieldName, $id_metaData, $input);

			Session::put('instanceData', array_except($input, '_method'));
			$dateTime = new \DateTime;
			$dateTime = $dateTime->format('Y-m-d H:i:s');
			// First validate if it can be erased, that means if it doesn't have dependencies
			$result = DB::table($nameStructure)->where('id', $id)
			            			->update(array('deleted_at' => $dateTime));
			if ($result)
				return Redirect::route('tasks.create')
								->withInput()
								->with('message', trans('ui.successfullyDeleted'));
			else
				return Redirect::route('tasks.create')
								->withInput()
								->with('message', trans('ui.couldntDeleteRow'));

		}
	}

	public function createDetail()
	{
		$modelName = Session::get('modelName');	

		$id_activitiesProcess = Session::get('id_activitiesProcess');
		$initialActivities = Session::get('initialActivities');

		$activities = Activity::join('activitiesProcesses', 'activitiesProcesses.id_activity', '=', 'activities.id')
										->where('activitiesProcesses.id', '=', $id_activitiesProcess)
										->where('activities.isActive', '=', 'Yes')
										->get();

		if ($activities->count()>0)
		{
			foreach($activities as $activity)
			{
				$id_typesActivity = $activity->id_typesActivity;
				$id_application = $activity->id_application;
				$id_subprocess = $activity->id_subprocess;
				$id_process = $activity->id_process;
				$externalReference = '';
			}
			// if Autogenerated
			if ($activity->id_typesActivity == 1)
			{
				$process = Process::where('id', '=', $id_process)
									->where('isActive', '=', 'Yes')
									->first();

				if ($process)
				{
					$id_metaData = $process->id_metaData;

					$tableName = '_data_' . $id_metaData;
					// Check if the table has been created
					$metaData = MetaData::where('id', '=', $id_metaData)
									->where('isActive', '=', 'Yes')
									->where('status', '=', 'Updated')
									->get();
					if ($metaData)
					{
						$assistantAddressArray = null;
						$fields = Field::where('id_metaData', '=', $id_metaData)
										->where('isActive', '=', 'Yes')
										->where('isVisible', '=', 'Yes')
										->orderBy('positionUI', 'ASC')
										->get();

						$dd = array();
						foreach($fields as $field)
						{
							if ($field->isLinked == 'Yes')
							{
								$structure = Structure::where('id', '=', $field->id_structure)->first();
								if ($structure)
								{
									$structureName = $structure->name;
									if ($field->relations)
										$data = array();
									else
									{
										if (strtolower($structure->name) == 'contacts')
										{
											$data = DB::table($structureName)
														->select('id', DB::raw('concat(firstName, " ", lastName) as fullName'))
														->where('isActive', '=', 'Yes')
														->whereNull('deleted_at')
														->lists('fullName', 'id');
										}
										elseif (strtolower($structure->name) == 'orders')
										{
											$data = DB::table($structureName)
														->whereNull('deleted_at')
														->lists('number', 'id');
										}
										elseif (strtolower($structure->name) == 'businesses')
										{
											$data = DB::table($structureName)
														->whereNull('deleted_at')
														->lists('name', 'id');
										}
										elseif (strtolower($structure->name) == 'addresses')
										{
											if ($field->hasAssistant == 'Yes')
												$assistantAddressArray = array();
											$data = DB::table($structureName)
														->select('id', DB::raw('concat(addressLine1, CASE WHEN suite IS NULL THEN "" WHEN suite = "" THEN "" ELSE concat(" #",suite) END, " - ", CASE WHEN zipcode IS NULL THEN "" ELSE zipcode END) as address'))
														->whereNull('deleted_at')
														->lists('address', 'id');
										}
										else
										{
											$data = DB::table($structureName)
														->where('isActive', '=', 'Yes')
														->whereNull('deleted_at')
														->lists('name', 'id');
										}
									}
									if ($field->isNullable == 'Yes')
										$data = array(0 => trans('ui.none')) + $data;
									$dd[$field->id] = $data;					
								}
							}
						}
						// Get the current location
						$lat = floatval(Session::get('lat'));
						$lon = floatval(Session::get('lon'));
						// Prepare the AddressAssistant
						if (is_array($assistantAddressArray))
						{
							if (Session::has('lastAddressArray'))
								$assistantAddressArray = Session::get('lastAddressArray');
						}
						else
							$assistantAddressArray = array();
						// We add the last Address
						if (Session::has('lastAddress'))
							array_unshift($assistantAddressArray, array('id_address' => 0, 'id_business' => 0, 'name' => '', 'vicinity' => Session::get('lastAddress'), 'types' => null, 'distance' => 0, 'text' => Session::get('lastAddress') . '=>' . 'Last address'));
						// We add the default option
						array_unshift($assistantAddressArray, array('id_address' => 0, 'id_business' => 0, 'name' => 'Enter your own address below...', 'vicinity' => null, 'types' => null, 'distance' => 0, 'text' => 'Enter your own address below...'));

						$_minCharactersAutocomplete = Session::get('_minCharactersAutocomplete');
						return parent::createDetail()->with('id_activitiesProcess', $id_activitiesProcess)
												->with('id_employee', Auth::user()->id_employee)
									        	->with('initialActivities', $initialActivities)
									        	->with('id_typesActivity', $activity->id_typesActivity)
									        	->with('id_metaData', $id_metaData)
									        	->with('modelName', $modelName)
									        	->with('tableName', $tableName)
									        	->with('externalReference', $externalReference)
									        	->with('id_statusInstance', '1')
									        	->with('fields', $fields)
									        	->with('assistantAddressArray', $assistantAddressArray)
									        	->with('_minCharactersAutocomplete', $_minCharactersAutocomplete)
									        	->with('dd', $dd);
					}
				}
			}
			// If Application
			else if ($activity->id_typesActivity == 2)
			{

			}
			// If Process
			else if ($activity->id_typesActivity == 3)
			{

			}
			/*
			if ($externalReference)
			{
				if (View::exists('applications.' . $externalReference))
			        return parent::create()->with('id_activitiesProcess', $id_activitiesProcess)
			        						->with('initialActivities', $initialActivities)
			        						->with('externalReference', $externalReference);
			    else
					return Redirect::route($modelName. '.index')->with('message', trans('ui.externalReferenceNotFound') . ': ' . $externalReference);
			}
		    else
				return Redirect::route($modelName. '.index')->with('message', trans('ui.externalReferenceNotFound') . ': ' . $externalReference);
			*/
		}
		return Redirect::route($modelName . '.index')
						->withInput()
						->with('message', trans('ui.couldntCreateTask'));

	}

	public function store()
	{
		$modelName = Session::get('modelName');
		$id_activitiesProcess = Session::get('id_activitiesProcess');
		$tableName = Input::get('tableName');
		$result = self::storeAll($id_activitiesProcess, $tableName);
		if ($result)
			return Redirect::route($modelName. '.edit', $result)
							->with('information', trans('ui.infoSuccessfullyCreated'));
		else
		{
			// Delete Instance and Task
			return Redirect::route($modelName. '.create')
						->withInput()
						->with('activitiesProcess', $id_activitiesProcess)
						->with('message', trans('ui.couldNotSaveData'));
		}
	}

	public function storeAll($id_activitiesProcess, $tableName)
	{
		$modelName = Session::get('modelName');
		$mainTableName = $tableName;
		$input = Input::all();	
		$id_employee = Auth::user()->id_employee;
		$id_typesActivity = Input::get('id_typesActivity');
		$id_metaData = Input::get('id_metaData');
		// $mainTableName = Input::get('tableName');
		$id_database = Organization::getDatabaseFromUser(Auth::user());
		// Creating Instance with status Pending
		$instance = new Instance;
		$instance->id_statusInstance = 1;
		$result = $instance->save();

		if ($result)
		{
			// Create Task with status Pending
			$task = new Task;
			$task->id_instance = $instance->id;
			$task->id_activitiesProcess = $id_activitiesProcess;
			$task->id_employee = $id_employee;
			$task->id_statusTask = 1;
			$task->duration = Input::get('duration');
			$task->notes = Input::get('notes');
			$result = $task->save();
			if ($result)
			{
				$dateTime = new \DateTime;
				$dateTime = $dateTime->format('Y-m-d H:i:s');
				$data = array('id_instance' => $instance->id, 'id_task' => $task->id, 'id_employee' => $id_employee, 'created_at' => $dateTime, 'updated_at' => $dateTime);

				// if Autogenerated
				if ($id_typesActivity == 1)
				{
					$fields = Field::where('id_metaData', '=', $id_metaData)
									->where('isActive', '=', 'Yes')
									->where('isVisible', '=', 'Yes')
									->where('isSystem', '=', 'No')
									->orderBy('positionUI', 'ASC')
									->get();
					$temp = array();
					$summary = '';
					$reference = array();
					foreach($fields as $field)
					{
						// We save all the detailed information in a text field in Tasks
						if ($field->isLinked == 'Yes')
						{
							$structure = Structure::where('id', '=', $field->id_structure)->first();
							if ($structure)
							{
								$structureName = $structure->name;
								if (strtolower($structure->name) == 'contacts')
								{
									// Check for the text in the field
									$tableName = str_plural(substr(strstr($field->name, '_'),1));
									$fieldValue = Input::get($tableName);
									if ($fieldValue)
									{
										if ($field->relations)
										{
									    	$firstName = Contact::getFirstName($fieldValue);
									    	$lastName = Contact::getLastName($fieldValue);
									    	$position = ContactsBusiness::getPosition($fieldValue);

									    	$joinTable = strstr($field->relations, ':', true);
									    	$joinField = substr(strstr($field->relations, ':'),1);
											// First try to find a record for that that location
											$row = DB::table($tableName)
														->select($tableName . '.id')
														->join($joinTable, $joinTable . '.' . $field->name, '=', $tableName . '.id')
														->where($joinTable . '.' . $joinField, '=', Input::get($joinField))
														->where($tableName .'.firstName', '=', $firstName)
														->where($tableName .'.lastName', '=', $lastName)
														->first();
											// If the location exists, use it
											if ($row)
											{
										    	$input[$field->name] = $row->id;
												Input::merge($input);
												// Update the position
												$className = ucfirst(str_singular($joinTable));
												$objectJoin = new $className;
										    	$fieldName = $field->name;
												$objectJoin = $objectJoin->where($fieldName, '=', $row->id)
																			->where($joinField, '=', Input::get($joinField))
																			->get();
												if ($objectJoin->count() == 1)
												{
													$objectJoin = $objectJoin->first();
													// if we found the contactBusiness, update
											    	$objectJoin->autoHydrateEntityFromInput = false;
											    	$objectJoin->forceEntityHydrationFromInput = false;
													$objectJoin->position = $position;
													$results = $objectJoin->save();
												}
												elseif ($objectJoin->count() == 0)
												{
													$objectJoin = new $className;
											    	$objectJoin->autoHydrateEntityFromInput = false;
											    	$objectJoin->forceEntityHydrationFromInput = false;
													$objectJoin->$fieldName = $row->id;
													$objectJoin->$joinField = Input::get($joinField);
													$objectJoin->position = $position;
													$results = $objectJoin->save();
												}
												else
													$results = 0;
												if (!$results)
												{
													// Error
													dd('Couldnt save the ' . $className);
												}
											}
											else
											{
												// Create the contact
												$className = ucfirst(substr(strstr($field->name, '_'),1));
												$object = new $className;
										    	$object->autoHydrateEntityFromInput = false;
										    	$object->forceEntityHydrationFromInput = false;
										    	// Get firstName, lastName and position

												$object->firstName = $firstName;
												$object->lastName = $lastName;
												$object->id_database = $id_database;
												$results = $object->save();
												if (!$results)
												{
													// Error
													dd('Couldnt save the ' . $className);
												}
												// Create the contactBusiness
												$className = ucfirst(str_singular($joinTable));
												$objectJoin = new $className;
										    	$objectJoin->autoHydrateEntityFromInput = false;
										    	$objectJoin->forceEntityHydrationFromInput = false;
										    	$fieldName = $field->name;
												$objectJoin->$fieldName = $object->id;
												$objectJoin->$joinField = Input::get($joinField);
												$objectJoin->position = $position;
												$results = $objectJoin->save();
												if (!$results)
												{
													// Error
													dd('Couldnt save the ' . $className);
												}
										    	$input[$field->name] = $object->id;
												Input::merge($input);
											}
										}
									}
									elseif ($field->isNullable == 'No')
									{
										// Send error because we can't work without contact information
										dd('Couldnt save without Contact information');
									}
									$info = DB::table($structure->name)
														->select('id', DB::raw('concat(firstName, " ", lastName) as fullName'))
														->where('id', '=', Input::get($field->name))
														->lists('fullName');
									if ($info)
									{
										$info = $info[0];
										if ($field->isReference == 'Yes')
											$reference[$field->positionReference] = $info;
										else
											$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . $info . '<br>';

									}
								}
								elseif (strtolower($structure->name) == 'orders')
								{
									$info = DB::table($structure->name)->select('number')
														->where('id', '=', Input::get($field->name))
														->lists('number');
									if ($info)
									{
										$info = $info[0];
										if ($field->isReference == 'Yes')
											$reference[$field->positionReference] = $info;
										else
											$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . $info . '<br>';
									}
								}
								elseif (strtolower($structure->name) == 'addresses')
								{
									// Check for the text in addresses										
									$addressText = Input::get(str_plural(substr(strstr($field->name, '_'),1)));									
									if ($addressText)
									{
										// Check if the address is complete
										if (!strpos($addressText, ','))
										{
											// Get information from current position
											$lat = Input::get('lat');
											$lon = Input::get('lon');
											$geocodeAux = Geocoder::reverse($lat, $lon);
											$addressText = $addressText . ', ' . $geocodeAux->getCity();
										}
										Session::put('lastAddress', $addressText);
										try {
										    $geocode = Geocoder::geocode($addressText);
										    // If exists, create the address and put the id in the form
										    if ($geocode)
										    {
										    	$address = new Address;
										    	// Search for that address in the DB
										    	$addressCopy = new Address;
										    	$address->autoHydrateEntityFromInput = false;
										    	$address->forceEntityHydrationFromInput = false;
										    	$address->getAddress($geocode, $addressText, $id_database);
										    	//dd($address);
										    	$addressCopy = Address::where('addressLine1', '=', $address->addressLine1)
										    							->where('suite', '=', $address->suite)
										    							->where('id_city', '=', $address->id_city)
										    							->first();
										    	// If we found it, use it
										    	if ($addressCopy)
										    		$address = $addressCopy;
										    	// if not, we create a new one
										    	else
										    	{
										    		$result = $address->save();
													if (!$result)
													{
														// If there was a mistake, send an error
														dd('Error, we could not save the address information');
													}
										    	}
												// Update the fields
										    	$input['id_address'] = $address->id;
													Input::merge($input);
										    }
										    // The GoogleMapsProvider will return a result
										} catch (\Exception $e) {
										    // No exception will be thrown here
										    dd($e->getMessage());
										}
									}
									$info = DB::table($structure->name)->select('addressLine1')
														->where('id', '=', Input::get($field->name))
														->lists('addressLine1');
									if ($info)
									{
										$info = $info[0];
										if ($field->isReference == 'Yes')
											$reference[$field->positionReference] = $info;
										else
											$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . $info . '<br>';
									}
								}
								elseif (strtolower($structure->name) == 'businesses')
								{
									// Check for the text in the field
									$tableName = str_plural(substr(strstr($field->name, '_'),1));
									$fieldValue = Input::get($tableName);
									if ($fieldValue)
									{
										if ($field->relations)
										{
									    	$joinTable = strstr($field->relations, ':', true);
									    	$joinField = substr(strstr($field->relations, ':'),1);
											// First try to find a record for that that location
											$row = DB::table($tableName)
														->select($tableName . '.id')
														->join($joinTable, $joinTable . '.' . $field->name, '=', $tableName . '.id')
														->where($tableName . '.name', '=', $fieldValue)
														->where($joinTable . '.' . $joinField, '=', Input::get($joinField))
														->first();
											// If the location exists, use it
											if ($row)
											{
										    	$input[$field->name] = $row->id;
												Input::merge($input);
											}
											else
											{
												// Create the business
												$className = ucfirst(substr(strstr($field->name, '_'),1));
												$object = new $className;
										    	$object->autoHydrateEntityFromInput = false;
										    	$object->forceEntityHydrationFromInput = false;
												$object->name = $fieldValue;
												$object->id_database = $id_database;
										    	$object->description = Input::get('businessDescription');
												$results = $object->save();
												if (!$results)
												{
													// Error
													dd('Couldnt save the ' . $className);
												}
												// Create the location
												$className = ucfirst(str_singular($joinTable));
												$objectJoin = new $className;
										    	$objectJoin->autoHydrateEntityFromInput = false;
										    	$objectJoin->forceEntityHydrationFromInput = false;
										    	$fieldName = $field->name;
												$objectJoin->$fieldName = $object->id;
												$objectJoin->$joinField = Input::get($joinField);
												$objectJoin->id_statusLocation = 1;
												$results = $objectJoin->save();
												if (!$results)
												{
													// Error
													dd('Couldnt save the ' . $className);
												}
										    	$input[$field->name] = $object->id;
												Input::merge($input);
											}
										}
										// If does not exists, create the business and then the location
									}
									elseif ($field->isNullable == 'No')
									{
										// Send error because we can't work without business information
										dd('Couldnt save without Business information');
									}
									$info = DB::table($structure->name)->select('name')
														->where('id', '=', Input::get($field->name))
														->lists('name');
									if ($info)
									{
										$info = $info[0];
										if ($field->isReference == 'Yes')
											$reference[$field->positionReference] = $info;
										else
											$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . $info . '<br>';
									}
								}
								else
								{
									// TO BE COMPLETED. This has to be procedure
									if ($field->name == 'id_response')
									{
										if (Input::get($field->name) == 2)
											$task->isAppointment = 'Yes';
										else
											$task->isAppointment = 'No';
									}
									$info = DB::table($structure->name)->select('name')
														->where('id', '=', Input::get($field->name))
														->lists('name');
									if ($info)
									{
										$info = $info[0];
										if ($field->isReference == 'Yes')
											$reference[$field->positionReference] = $info;
										else
											$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . $info . '<br>';
									}
								}
							}
						}
						else
						{
							// Prepare the summary and reference fields
							if ((Input::get($field->name) != 0 && $field->id_dataType == 1) ||
								(Input::get($field->name) != 0 && $field->id_dataType == 7) ||
								(Input::get($field->name) != 0 && $field->id_dataType == 8) ||
								(Input::get($field->name) != 0 && $field->id_dataType == 9) ||
								(Input::get($field->name) != 0 && $field->id_dataType == 10) ||
								(Input::get($field->name) != '' && $field->id_dataType == 4) ||
								(Input::get($field->name) != '' && $field->id_dataType == 12) ||
								(Input::get($field->name) != 'Unknown' && $field->id_dataType == 15))
							{
								if ($field->isReference == 'Yes')
									$reference[$field->positionReference] = Input::get($field->name);
								else
									$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . Input::get($field->name) . '<br>';
							}
						}

						// Check if it is a dataType = Date or DateTime
						if ($field->id_dataType == 4)
							$temp = $temp + array($field->name => date_create_from_format('Y-m-d', Input::get($field->name)));
						elseif ($field->id_dataType == 12)
							$temp = $temp + array($field->name => date_create_from_format('Y-m-d H:i:s', Input::get($field->name)));
						elseif (Input::get($field->name) == 0 && $field->isLinked == 'Yes')
							$temp = $temp + array($field->name => null);
						else
							$temp = $temp + array($field->name => Input::get($field->name));

						// If any non null field is not provided, send an error
						if (Input::get($field->name) == 0 && $field->isLinked == 'Yes' && $field->isNullable == 'No')
						{
							// Delete Instance and Task
							$task->delete();
							$instance->delete();					
							return Redirect::route($modelName. '.create')
										->withInput()
										->with('id_activitiesProcess', $id_activitiesProcess)
										->with('message', trans('ui.fieldShouldntBeNull') . ': ' . trans('ui'.$field->name));
						}
					}
					if (Input::get('dueDate') == '')
						$task->dueDate = null;
					else	
					{
						$task->dueDate = date_create_from_format('Y-m-d H:i:s', Input::get('dueDate'));
						$summary = $summary . '<b>' . trans('ui.dueDate') . ': </b>' . $task->dueDate->format('Y-m-d H:i:s') . '<br>';
					}
					if ($task->notes)
						$summary = $summary . '<b>' . trans('ui.notes') . ': </b>' . $task->notes . '<br>';


					$task->summary = $summary;
					ksort($reference);
					$task->reference = implode("<br>", $reference);
					$task->save();
					$data = $data + $temp;
				}
				// Creating _data_
				$result = DB::table($mainTableName)->insert($data);
				if (!$result)
				{
					$task->delete();
					$instance->delete();					
				}
				else
					$result = $task->id;
				return $result;
			}
			else
			{
				// Delete the last instance
				$instance->delete();
				// Send error message
				return Redirect::route($modelName. '.create')
							->withInput()
							->with('activitiesProcess', $id_activitiesProcess)
							->with('message', trans('ui.couldNotSaveTask'));
			}
		}
		else
		{
			// Send error message
			return Redirect::route($modelName. '.create')
						->withInput()
						->with('activitiesProcess', $id_activitiesProcess)
						->with('message', trans('ui.couldNotSaveInstance'));
		}
	}

	public function edit($id)
	{
		$modelName = Session::get('modelName');	

		$task = Task::where('id', '=', $id)->first();
		$id_activitiesProcess = $task->id_activitiesProcess;
		if (!$id_activitiesProcess)
		{
			if (!Session::has('id_activitiesProcess'))
			{
				return Redirect::route($modelName . '.index')
								->withInput()
								->with('message', trans('ui.couldntCreateTask'));
			}
			else
				$id_activitiesProcess = Session::get('id_activitiesProcess');
		}
		else
			Session::put('id_activitiesProcess', $id_activitiesProcess);

		$id_process = ActivitiesProcess::where('id', '=', $id_activitiesProcess)
										->first()->id_process;

		if ($id_process)
			$id_campaign = Process::where('id', '=', $id_process)
									->first()->id_campaign;

		if ($id_campaign)
		{
			Session::put('id_campaign', $id_campaign);
			return parent::edit($id)->withInput(Session::get('instanceData'));;
		}
		else
				return Redirect::route($modelName . '.index')
								->withInput()
								->with('message', trans('ui.couldntCreateTask'));
	}

	public function editDetail()
	{
		$modelName = Session::get('modelName');	

		if (Session::has('id'))
			$id = Session::get('id');
		else
			$id = Session::get('id_base');
		Session::put('id_base', $id);

		$task = Task::where('id', '=', $id)
					->first();
		$id_activitiesProcess = $task->id_activitiesProcess;
		$initialActivities = Session::get('initialActivities');

		$activities = Activity::join('activitiesProcesses', 'activitiesProcesses.id_activity', '=', 'activities.id')
										->where('activitiesProcesses.id', '=', $id_activitiesProcess)
										->where('activities.isActive', '=', 'Yes')
										->get();
		if ($activities)
		{
			foreach($activities as $activity)
			{
				$id_typesActivity = $activity->id_typesActivity;
				$id_application = $activity->id_application;
				$id_subprocess = $activity->id_subprocess;
				$id_process = $activity->id_process;
				$externalReference = '';
			}
			// if Autogenerated
			if ($activity->id_typesActivity == 1)
			{
				$process = Process::where('id', '=', $id_process)
									->where('isActive', '=', 'Yes')
									->first();
				if ($process)
					$id_metaData = $process->id_metaData;

				$tableName = '_data_' . $id_metaData;	
				$fields = Field::where('id_metaData', '=', $id_metaData)
								->where('isActive', '=', 'Yes')
								->where('isVisible', '=', 'Yes')
								->orderBy('positionUI', 'ASC')
								->get();
				$dd = array();
				$values = array();
				$previousValues = array();

				foreach($fields as $field)
				{
					if ($field->isLinked == 'Yes')
					{
						$structure = Structure::where('id', '=', $field->id_structure)->first();
						if ($structure)
						{
							$structureName = $structure->name;
							if ($field->relations && $field->isFullSearch == 'Yes')
								$data = array();
							else
							{
								if (strtolower($structure->name) == 'contacts')
								{
									if (!$field->relations)
									{
										$data = DB::table($structureName)
													->select('id', DB::raw('concat(firstName, " ", lastName) as fullName'))
													->where('isActive', '=', 'Yes')
													->whereNull('deleted_at')
													->lists('fullName', 'id');
									}
									else
									{
								    	$joinTable = strstr($field->relations, ':', true);
								    	$joinField = substr(strstr($field->relations, ':'),1);
										$data = DB::table($structureName)
													->join($joinTable, $joinTable . '.id_' . str_singular($structureName), '=', $structureName . '.id')
													->select($structureName . '.id', DB::raw('concat(firstName, " ", lastName) as fullName'))
													->where($structureName . '.isActive', '=', 'Yes')
													->whereNull($structureName . '.deleted_at')
													->where($joinTable . '.' . $joinField, '=', $previousValues[$joinField])													
													->lists('fullName', 'id');
									}
								}
								elseif (strtolower($structure->name) == 'orders')
								{
									if (!$field->relations)
									{
										$data = DB::table($structureName)
													->whereNull('deleted_at')
													->lists('number', 'id');
									}
									else
									{
								    	$joinTable = strstr($field->relations, ':', true);
								    	$joinField = substr(strstr($field->relations, ':'),1);
										$data = DB::table($structureName)
													->join($joinTable, $joinTable . '.id_' . str_singular($structureName), '=', $structureName . '.id')
													->select($structureName . '.id', $structureName . '.number')
													->where($structureName . '.isActive', '=', 'Yes')
													->whereNull($structureName . '.deleted_at')
													->where($joinTable . '.' . $joinField, '=', $previousValues[$joinField])													
													->lists('number', 'id');
									}
								}
								elseif (strtolower($structure->name) == 'businesses')
								{
									if (!$field->relations)
									{
										$data = DB::table($structureName)
													->whereNull('deleted_at')
													->lists('name', 'id');
									}
									else
									{
								    	$joinTable = strstr($field->relations, ':', true);
								    	$joinField = substr(strstr($field->relations, ':'),1);
										$data = DB::table($structureName)
													->join($joinTable, $joinTable . '.id_' . str_singular($structureName), '=', $structureName . '.id')
													->select($structureName . '.id', $structureName . '.name')
													->where($structureName . '.isActive', '=', 'Yes')
													->whereNull($structureName . '.deleted_at')
													->where($joinTable . '.' . $joinField, '=', $previousValues[$joinField])													
													->lists('name', 'id');										
									}
								}
								elseif (strtolower($structure->name) == 'addresses')
								{
									if (!$field->relations)
									{
										$data = DB::table($structureName)
													//->select('id', DB::raw('concat(addressLine1, CASE WHEN suite IS NULL THEN "" WHEN suite = "" THEN "" ELSE concat(" #",suite) END, " - ", CASE WHEN zipcode IS NULL THEN "" ELSE zipcode END) as address'))
													->whereNull('deleted_at')
													->lists('addressLine1', 'id');
									}
									else
									{
								    	$joinTable = strstr($field->relations, ':', true);
								    	$joinField = substr(strstr($field->relations, ':'),1);
										$data = DB::table($structureName)
													->join($joinTable, $joinTable . '.id_' . str_singular($structureName), '=', $structureName . '.id')
													->select($structureName . '.id', $structureName . '.addressLine1')
													->where($structureName . '.isActive', '=', 'Yes')
													->whereNull($structureName . '.deleted_at')
													->where($joinTable . '.' . $joinField, '=', $previousValues[$joinField])													
													->lists('addressLine1', 'id');										
									}
								}
								else
								{
									if (!$field->relations)
									{
										$data = DB::table($structureName)
													->where('isActive', '=', 'Yes')
													->whereNull('deleted_at')
													->lists('name', 'id');
									}
									else
									{
								    	$joinTable = strstr($field->relations, ':', true);
								    	$joinField = substr(strstr($field->relations, ':'),1);
										$data = DB::table($structureName)
													->join($joinTable, $joinTable . '.id_' . str_singular($structureName), '=', $structureName . '.id')
													->select($structureName . '.id', $structureName . '.name')
													->where($structureName . '.isActive', '=', 'Yes')
													->whereNull($structureName . '.deleted_at')
													->where($joinTable . '.' . $joinField, '=', $previousValues[$joinField])													
													->lists('name', 'id');										
									}
								}
							}
							if ($field->isNullable == 'Yes')
								$data = array(0 => trans('ui.none')) + $data;
							$dd[$field->id] = $data;
							// This part is for autocomplete					
							if ($field->isFullSearch == 'Yes')
							{
								$value = DB::table($tableName)
										->where('id_instance', '=', $task->id_instance)
										->whereNull('deleted_at')
										->lists($field->name);	
								$value = $value[0];
								if (strtolower($structure->name) == 'contacts')
								{
									$text = DB::table($structureName)
												->select(DB::raw('concat(firstName, CASE WHEN lastName IS NULL THEN "" WHEN lastName = "" THEN "" ELSE concat(" ",lastName) END, CASE WHEN position IS NULL THEN "" WHEN position = "" THEN "" ELSE concat(", ",position) END) as fullName'))
												->leftjoin('contactsBusinesses', $structureName . '.id', '=', 'contactsBusinesses.id_contact')
												->where($structureName . '.isActive', '=', 'Yes')
												->whereNull($structureName . '.deleted_at')
												->where($structureName . '.id', '=', $value)
												->lists('fullName');
								}
								elseif (strtolower($structure->name) == 'orders')
								{
									$text = DB::table($structureName)
												->whereNull('deleted_at')
												->where('id', '=', $value)
												->lists('number');
								}
								elseif (strtolower($structure->name) == 'businesses')
								{
									$text = DB::table($structureName)
												->whereNull('deleted_at')
												->where('id', '=', $value)
												->lists('name');
								}
								elseif (strtolower($structure->name) == 'addresses')
								{
									$text = DB::table($structureName)
												->select(DB::raw('concat(addressLine1, CASE WHEN suite IS NULL THEN "" WHEN suite = "" THEN "" ELSE concat(" #",suite) END, ", " , cities.name) as fullAddress'))
												->join('cities', $structureName . '.id_city', '=', 'cities.id')
												->whereNull($structureName . '.deleted_at')
												->where($structureName . '.id', '=', $value)
												->lists('fullAddress');
								}
								else
								{
									$text = DB::table($structureName)
												->where('isActive', '=', 'Yes')
												->whereNull('deleted_at')
												->where('id', '=', $value)
												->lists('name');
								}
								if ($text)
									$autocomplete[$field->id] = $text[0];
								else
									$autocomplete[$field->id] = null;
							}
						}
					}
					$data = DB::table($tableName)
							->where('id_instance', '=', $task->id_instance)
							->whereNull('deleted_at')
							->lists($field->name);
					if ($data[0] == '0000-00-00')
					{
						$values[$field->id] = '';
						$previousValues[$field->name] = '';
					}
					else
					{
						$values[$field->id] = $data[0];
						$previousValues[$field->name] = $data[0];
					}
				}				
				$_minCharactersAutocomplete = Session::get('_minCharactersAutocomplete');
				return parent::editDetail()->with('id', $id)
										->with('id_activitiesProcess', $id_activitiesProcess)
										->with('id_employee', Auth::user()->id_employee)
							        	->with('initialActivities', $initialActivities)
							        	->with('id_typesActivity', $activity->id_typesActivity)
							        	->with('id_metaData', $id_metaData)
							        	->with('modelName', $modelName)
							        	->with('tableName', $tableName)
							        	->with('externalReference', $externalReference)
							        	->with('id_statusInstance', '1')
										->with('dueDate', $task->dueDate)
										->with('expirationDate', $task->expirationDate)
										->with('duration', $task->duration)
										->with('notes', $task->notes)
							        	->with('fields', $fields)
							        	->with('values', $values)
							        	->with('autocomplete', $autocomplete)
							        	->with('_minCharactersAutocomplete', $_minCharactersAutocomplete)
							        	->with('dd', $dd);
			}
			// If Application
			else if ($activity->id_typesActivity == 2)
			{

			}
			// If Process
			else if ($activity->id_typesActivity == 3)
			{

			}
			/*
			if ($externalReference)
			{
				if (View::exists('applications.' . $externalReference))
			        return parent::create()->with('id_activitiesProcess', $id_activitiesProcess)
			        						->with('initialActivities', $initialActivities)
			        						->with('externalReference', $externalReference);
			    else
					return Redirect::route($modelName. '.index')->with('message', trans('ui.externalReferenceNotFound') . ': ' . $externalReference);
			}
		    else
				return Redirect::route($modelName. '.index')->with('message', trans('ui.externalReferenceNotFound') . ': ' . $externalReference);
			*/
		}
		return Redirect::route($modelName . '.index')
						->withInput()
						->with('message', trans('ui.couldntEditTask'));
	}

	public function updateAll($id)
	{
		$modelName = Session::get('modelName');	

		$input = Input::all();	
		$dateTime = new \DateTime;
		$data = array('id_employee' => Auth::user()->id_employee, 'updated_at' => $dateTime);
		// We get all the information from the Task
		$task = Task::where('id', '=', $id)
						->where('isActive', '=', 'Yes')
						->first();

		// Getting Task information
		$id_activitiesProcess = $task->id_activitiesProcess;
		$activitiesProcess = ActivitiesProcess::where('id', '=', $task->id_activitiesProcess)
												->first();
		$id_process = $activitiesProcess->id_process;
		$process =  Process::where('id', '=', $id_process)
								->where('isActive', '=', 'Yes')
								->first();			
		$id_metaData = $process->id_metaData;
		$audit = $process->audit;

		// We get the name of the _data_ table with the metaData
		$tableName = '_data_' . $id_metaData;
		$id_instance = $task->id_instance;
		//$id_employee = $task->id_employee;
		$id_statusTask = $task->id_statusTask;

		$mainTableName = $tableName;
		$id_database = Organization::getDatabaseFromUser(Auth::user());

		$fields = Field::where('id_metaData', '=', $id_metaData)
						->where('isActive', '=', 'Yes')
						->where('isSystem', '=', 'No')
						->where('isVisible', '=', 'Yes')
						->orderBy('positionUI', 'ASC')
						->get();
		$temp = array();
		$summary = '';
		$reference = array();
		foreach($fields as $field)
		{
			// If any non null field is not provided, send an error
			if (Input::get($field->name) == 0 && $field->isLinked == 'Yes' && $field->isNullable == 'No')
			{				
				// Send error message
				return Redirect::route($modelName. '.edit', $id)
							->withInput(Session::get('instanceData'))
							->with('message', trans('ui.nonNullFieldNotProvided'));
			}

			// We save all the detailed information in a text field in Tasks
			if ($field->isLinked == 'Yes')
			{
				$structure = Structure::where('id', '=', $field->id_structure)->first();
				if ($structure)
				{
					$structureName = $structure->name;
					if (strtolower($structure->name) == 'contacts')
					{
						// Check for the text in the field
						$tableName = str_plural(substr(strstr($field->name, '_'),1));
						$fieldValue = Input::get($tableName);
						if ($fieldValue)
						{
							if ($field->relations)
							{
						    	$firstName = Contact::getFirstName($fieldValue);
						    	$lastName = Contact::getLastName($fieldValue);
						    	$position = ContactsBusiness::getPosition($fieldValue);

						    	$joinTable = strstr($field->relations, ':', true);
						    	$joinField = substr(strstr($field->relations, ':'),1);
								// First try to find a record for that that location
								$row = DB::table($tableName)
											->select($tableName . '.id')
											->join($joinTable, $joinTable . '.' . $field->name, '=', $tableName . '.id')
											->where($joinTable . '.' . $joinField, '=', Input::get($joinField))
											->where($tableName .'.firstName', '=', $firstName)
											->where($tableName .'.lastName', '=', $lastName)
											->first();
								// If the location exists, use it
								if ($row)
								{
							    	$input[$field->name] = $row->id;
									Input::merge($input);
									// Update the position
									$className = ucfirst(str_singular($joinTable));
									$objectJoin = new $className;
							    	$fieldName = $field->name;
									$objectJoin = $objectJoin->where($fieldName, '=', $row->id)
																->where($joinField, '=', Input::get($joinField))
																->get();
									if ($objectJoin->count() == 1)
									{
										// if we found the contactBusiness, update
										$objectJoin = $objectJoin->first();
								    	$objectJoin->autoHydrateEntityFromInput = false;
								    	$objectJoin->forceEntityHydrationFromInput = false;
										$objectJoin->position = $position;
										$results = $objectJoin->save();
									}
									elseif ($objectJoin->count() == 0)
									{
										$objectJoin = new $className;
								    	$objectJoin->autoHydrateEntityFromInput = false;
								    	$objectJoin->forceEntityHydrationFromInput = false;
										$objectJoin->$fieldName = $object->id;
										$objectJoin->$joinField = Input::get($joinField);
										$objectJoin->position = $position;
										$results = $objectJoin->save();
									}
									else
										$results = 0;
									if (!$results)
									{
										// Error
										dd('Couldnt save the ' . $className);
									}
								}
								else
								{
									// Create the contact
									$className = ucfirst(substr(strstr($field->name, '_'),1));
									$object = new $className;
							    	$object->autoHydrateEntityFromInput = false;
							    	$object->forceEntityHydrationFromInput = false;
							    	// Get firstName, lastName and position

									$object->firstName = $firstName;
									$object->lastName = $lastName;
									$object->id_database = $id_database;
									$results = $object->save();
									if (!$results)
									{
										// Error
										dd('Couldnt save the ' . $className);
									}
									// Create the contactBusiness
									$className = ucfirst(str_singular($joinTable));
									$objectJoin = new $className;
							    	$objectJoin->autoHydrateEntityFromInput = false;
							    	$objectJoin->forceEntityHydrationFromInput = false;
							    	$fieldName = $field->name;
									$objectJoin->$fieldName = $object->id;
									$objectJoin->$joinField = Input::get($joinField);
									$objectJoin->position = $position;
										$results = $objectJoin->save();
									if (!$results)
									{
										// Error
										dd('Couldnt save the ' . $className);
									}
							    	$input[$field->name] = $object->id;
									Input::merge($input);
								}
							}
						}
						elseif ($field->isNullable == 'No')
						{
							// Send error because we can't work without contact information
							dd('Couldnt save without Contact information');
						}
						$info = DB::table($structure->name)
											->select('id', DB::raw('concat(firstName, " ", lastName) as fullName'))
											->where('id', '=', Input::get($field->name))
											->lists('fullName');
						if ($info)
						{
							$info = $info[0];
							if ($field->isReference == 'Yes')
								$reference[$field->positionReference] = $info;
							else
								$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . $info . '<br>';
						}
					}
					elseif (strtolower($structure->name) == 'orders')
					{
						$info = DB::table($structure->name)->select('number')
											->where('id', '=', Input::get($field->name))
											->lists('number');
						if ($info)
						{
							$info = $info[0];
							if ($field->isReference == 'Yes')
								$reference[$field->positionReference] = $info;
							else
								$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . $info . '<br>';
						}
					}
					elseif (strtolower($structure->name) == 'addresses')
					{
						// Check for the text in addresses										
						$addressText = Input::get(str_plural(substr(strstr($field->name, '_'),1)));
						if ($addressText)
						{
							// Check if the address is complete
							if (!strpos($addressText, ','))
							{
								// Get information from current position
								$lat = Input::get('lat');
								$lon = Input::get('lon');
								$geocodeAux = Geocoder::reverse($lat, $lon);
								$addressText = $addressText . ', ' . $geocodeAux->getCity();
							}
							Session::put('lastAddress', $addressText);
							try {
							    $geocode = Geocoder::geocode($addressText);
							    // If exists, create the address and put the id in the form
							    if ($geocode)
							    {
							    	$address = new Address;
							    	// Search for that address in the DB
							    	$addressCopy = new Address;
							    	$address->autoHydrateEntityFromInput = false;
							    	$address->forceEntityHydrationFromInput = false;
							    	$address->getAddress($geocode, $addressText, $id_database);
							    	$addressCopy = Address::where('addressLine1', '=', $address->addressLine1)
							    							->where('suite', '=', $address->suite)
							    							->where('id_city', '=', $address->id_city)
							    							->first();
							    	// If we found it, use it
							    	if ($addressCopy)
							    		$address = $addressCopy;
							    	// if not, we create a new one
							    	else
							    	{
							    		$result = $address->save();
										if (!$result)
										{
											// If there was a mistake, send an error
											dd('Error, we could not save the address information');
										}
							    	}
									// Update the fields
							    	$input['id_address'] = $address->id;
										Input::merge($input);
							    }
							    // The GoogleMapsProvider will return a result
							} catch (\Exception $e) {
							    // No exception will be thrown here
							    dd($e->getMessage());
							}
						}
						$info = DB::table($structure->name)->select('addressLine1')
											->where('id', '=', Input::get($field->name))
											->lists('addressLine1');
						if ($info)
						{
							$info = $info[0];
							if ($field->isReference == 'Yes')
								$reference[$field->positionReference] = $info;
							else
								$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . $info . '<br>';
						}
					}
					elseif (strtolower($structure->name) == 'businesses')
					{
						// Check for the text in the field
						$tableName = str_plural(substr(strstr($field->name, '_'),1));
						$fieldValue = Input::get($tableName);
						if ($fieldValue)
						{
							if ($field->relations)
							{
						    	$joinTable = strstr($field->relations, ':', true);
						    	$joinField = substr(strstr($field->relations, ':'),1);
								// First try to find a record for that that location
								$row = DB::table($tableName)
											->select($tableName . '.id')
											->join($joinTable, $joinTable . '.' . $field->name, '=', $tableName . '.id')
											->where($tableName . '.name', '=', $fieldValue)
											->where($joinTable . '.' . $joinField, '=', Input::get($joinField))
											->first();
								// If the location exists, use it
								if ($row)
								{
							    	$input[$field->name] = $row->id;
									Input::merge($input);
								}
								else
								{
									// Create the business
									$className = ucfirst(substr(strstr($field->name, '_'),1));
									$object = new $className;
							    	$object->autoHydrateEntityFromInput = false;
							    	$object->forceEntityHydrationFromInput = false;
									$object->name = $fieldValue;
									$object->id_database = $id_database;
									$results = $object->save();
									if (!$results)
									{
										// Error
										dd('Couldnt save the ' . $className);
									}
									// Create the location
									$className = ucfirst(str_singular($joinTable));
									$objectJoin = new $className;
							    	$objectJoin->autoHydrateEntityFromInput = false;
							    	$objectJoin->forceEntityHydrationFromInput = false;
							    	$fieldName = $field->name;
									$objectJoin->$fieldName = $object->id;
									$objectJoin->$joinField = Input::get($joinField);
									$objectJoin->id_statusLocation = 1;
									$results = $objectJoin->save();
									if (!$results)
									{
										// Error
										dd('Couldnt save the ' . $className);
									}
							    	$input[$field->name] = $object->id;
									Input::merge($input);
								}
							}
							// If does not exists, create the business and then the location
						}
						elseif ($field->isNullable == 'No')
						{
							// Send error because we can't work without business information
							dd('Couldnt save without Business information');
						}
						$info = DB::table($structure->name)->select('name')
											->where('id', '=', Input::get($field->name))
											->lists('name');
						if ($info)
						{
							$info = $info[0];
							if ($field->isReference == 'Yes')
								$reference[$field->positionReference] = $info;
							else
								$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . $info . '<br>';
						}
					}
					else
					{
						if ($field->name == 'id_response')
						{
							if (Input::get($field->name) == 2)
								$isAppointment = 'Yes';
							else
								$isAppointment = 'No';
						}
						$info = DB::table($structure->name)->select('name')
											->where('id', '=', Input::get($field->name))
											->lists('name');
						if ($info)
						{
							$info = $info[0];
							if ($field->isReference == 'Yes')
								$reference[$field->positionReference] = $info;
							else
								$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . $info . '<br>';
						}
					}
				}
			}
			else
			{
				// Prepare the summary and reference fields
				if ((Input::get($field->name) != 0 && $field->id_dataType == 1) ||
					(Input::get($field->name) != 0 && $field->id_dataType == 7) ||
					(Input::get($field->name) != 0 && $field->id_dataType == 8) ||
					(Input::get($field->name) != 0 && $field->id_dataType == 9) ||
					(Input::get($field->name) != 0 && $field->id_dataType == 10) ||
					(Input::get($field->name) != '' && $field->id_dataType == 4) ||
					(Input::get($field->name) != '' && $field->id_dataType == 12) ||
					(Input::get($field->name) != 'Unknown' && $field->id_dataType == 15))
				{
					if ($field->isReference == 'Yes')
						$reference[$field->positionReference] = Input::get($field->name);
					else
						$summary = $summary . '<b>' . trans('ui.'.$field->name) . ': </b>' . Input::get($field->name) . '<br>';
				}
			}

			// Check if it is a dataType = Date or DateTime
			if ($field->id_dataType == 4)
				$temp = $temp + array($field->name => date_create_from_format('Y-m-d', Input::get($field->name)));
			elseif ($field->id_dataType == 12)
				$temp = $temp + array($field->name => date_create_from_format('Y-m-d H:i:s', Input::get($field->name)));
			elseif (Input::get($field->name) == 0 && $field->isLinked == 'Yes')
				$temp = $temp + array($field->name => null);
			else
				$temp = $temp + array($field->name => Input::get($field->name));

		}
		// Update Task
		if (Input::get('dueDate') == '')
			$dueDate = null;
		else	
		{
			$dueDate = date_create_from_format('Y-m-d H:i:s', Input::get('dueDate'));
			$summary = $summary . '<b>' . trans('ui.dueDate') . ': </b>' . $dueDate->format('Y-m-d H:i:s') . '<br>';
		}
		if (Input::get('notes'))
			$summary = $summary . '<b>' . trans('ui.notes') . ': </b>' . Input::get('notes') . '<br>';

		ksort($reference);
		$reference = implode("<br>", $reference);
		if (Auth::user()->id_employee)
			$result = Task::where('id', '=', $id)
							->update(array('id_employee' => Auth::user()->id_employee, 'summary' => $summary, 'reference' => $reference, 'dueDate' => $dueDate, 'duration' => Input::get('duration'), 'notes' => Input::get('notes'), 'isAppointment' => $isAppointment));
		else
			$result = Task::where('id', '=', $id)
							->update(array('summary' => $summary, 'reference' => $reference, 'dueDate' => $dueDate, 'duration' => Input::get('duration'), 'notes' => Input::get('notes'), 'isAppointment' => $isAppointment));

		if ($result)
			$data = $data + $temp;
		else
		{
			// Send error message
			return Redirect::route($modelName. '.edit', $id)
						->withInput()
						->with('message', trans('ui.couldNotSaveTask'));
		}
			
		// Creating _data_
		if ($audit == 'Yes')
		{
			$result = DB::table($mainTableName)
							->where('id_task' , '=', $id)
							->update($data);
		}
		else
		{
			$result = DB::table($mainTableName)
							->where('id_instance' , '=', $id_instance)
							->update($data);
		}
		return $result;
	}

	public function update($id)
	{
		$modelName = Session::get('modelName');	
		// if ($task->id_instance)
		// {
			$result = self::updateAll($id);
			if ($result)
				return Redirect::route($modelName. '.index')
								->with('information', trans('ui.infoSuccessfullyUpdated'));
			else
			{
				return Redirect::route($modelName. '.edit', $id)
							->withInput()
							->with('message', trans('ui.couldNotSaveData'));
			}
		// }
		// else
		// 	return Redirect::route($modelName. '.edit', $id)
		// 						->withInput()
		// 						->with('message', trans('ui.couldNotFindInstance'));
	}

	public function execute()
	{	
		$modelName = Session::get('modelName');	
		$id = Input::get('id');
		// If Editing			
		if ($id)	
			// Save the information
			$result = self::updateAll($id);
		else
		{
			dd(Input::all());
			$result = self::storeAll($id_activitiesProcess, $tableName);
		}
		if (!$result)
		{
			return Redirect::route($modelName. '.edit', $id)
						->withInput()
						->with('message', trans('ui.couldNotSaveData'));
		}
		$task = Task::find($id);
		$id_statusTask = $task->id_statusTask;
		$id_instance = $task->id_instance;
		$id_activitiesProcess = $task->id_activitiesProcess;

		// If the status of the task is Executed , show the message and go back
		if ($id_statusTask == 2)
		{
			return Redirect::route($modelName. '.edit', $id)
								->withInput()
								->with('message', trans('ui.thisTaskHasBeenPreviouslyExecuted'));
		}
		// If the status of the task is Terminated , show the message and go back
		elseif ($id_statusTask == 3)
		{
			return Redirect::route($modelName. '.edit', $id)
								->withInput()
								->with('message', trans('ui.thisTaskHasBeenTerminated'));
		}		
		// If the status of the task is Pending , we can process the Task
		elseif ($id_statusTask == 1)
		{
			$instance = Instance::where('id', '=', $id_instance)
									->first();

			// Getting Instance information
			$id_statusInstance = $instance->id_statusInstance;					

			// If the status of the Instance is Executed, show the message and go back
			if ($id_statusInstance == 2)
			{
				return Redirect::route($modelName. '.edit', $id)
									->withInput()
									->with('message', trans('ui.thisInstanceHasBeenExecuted'));
			}
			// If the status of the Instance is Terminated, show the message and go back
			elseif ($id_statusInstance == 3)
			{
				return Redirect::route($modelName. '.edit', $id)
									->withInput()
									->with('message', trans('ui.thisInstanceHasBeenTerminated'));
			}
			// If the status of the Instance is On Hold, show the message and go back
			elseif ($id_statusInstance == 4)
			{
				return Redirect::route($modelName. '.edit', $id)
									->withInput()
									->with('message', trans('ui.thisInstanceIsOnHold'));
			}
			// If the status of the Instance is Locked, show the message and go back
			elseif ($id_statusInstance == 5)
			{
				return Redirect::route($modelName. '.edit', $id)
									->withInput()
									->with('message', trans('ui.thisInstanceIsLocked'));
			}
			// If the status of the instance is Pending , we can process the Task
			elseif ($id_statusInstance == 1)
			{
				$activitiesProcess = ActivitiesProcess::where('id', '=', $id_activitiesProcess)
														->first();
				$id_process = $activitiesProcess->id_process;
				$id_activity = $activitiesProcess->id_activity;
				$id_typesAssignment = $activitiesProcess->id_typesAssignment;

				$process =  Process::where('id', '=', $id_process)
										->where('isActive', '=', 'Yes')
										->first();					

				$id_finalActivity = $process->id_finalActivity;
				$id_metaData = $process->id_metaData;
				$audit = $process->audit;
				$log = $process->log;

				// We get the name of the _data_ table with the metaData
				$tableName = '_data_' . $id_metaData;

				// First we send all the validation messages
				// TO BE COMPLETED LATER
				// $rules =  Rule::where('id_initialActivity', '=', $id_activitiesProcess)
				// 				->where('id_typesRule', '=', 2)
				// 				->get();

				// We get all the rules that starts in our initialActivity
				$rules =  Rule::where('id_initialActivity', '=', $id_activitiesProcess)
								->where('id_typesRule', '=', 1)
								->orderBy('secuence', 'ASC')
								->get();
				$countNotSatisfied = 0;
				foreach($rules as $key => $value)
				{
					// For each rule in the table we execute our logic on our _data_ table
					if ($audit == 'Yes')
					{
						$data = DB::table($tableName)
									->where('id_task', '=', $id)
									->whereRaw(DB::raw($value->logic))
									->first();
					}
					else
					{
						$data = DB::table($tableName)
									->where('id_instance', '=', $id_instance)
									->whereRaw(DB::raw($value->logic))
									->first();
					}

					if ($data)
					{						
						// The instance satisfied the logic for this rule so we create that task for that finalActivity
						$activity = Activity::where('id', '=', $value->id_nextActivity)
												->where('isActive', '=', 'Yes')
												->first();

						$id_subprocess = $activity->id_subprocess;
						$id_typesActivity = $activity->id_typesActivity;
						$nextActivityProcess = ActivitiesProcess::where('id', '=', $value->id_nextActivity)
																->first();

						$expiration = $nextActivityProcess->expiration;
						$expiration_value = $nextActivityProcess->expiration_value;
						// If the next Activity is a Subprocess
						if ($id_typesActivity == 3)
						{
							// TO BE COMPLETED LATER
							return Redirect::route($modelName. '.edit', $id)
												->withInput()
												->with('message', trans('ui.theSystemDoesntSupportSubprocesses'));
						}
						// If it is a normal Activity
						else
						{
							// Validate if the next Activity is the Final for the process
							if ($id_finalActivity == $value->id_nextActivity)
							{
								// We finish the task
								$task->id_statusTask = 2;
								$task->save();
								// If the instance has non Pending task, we finish the instance	
								$otherTasks = Task::where('id_instance', '=', $task->id_instance)
													->where('id_statusTask', '=', 1)
													->get();
								if (!$otherTasks->count())
								{
									// We Execute the Instance
									$instance = Instance::find($task->id_instance);
									$instance->id_statusInstance = 2;
									$instance->save();
									// We can exit
								}
								break;
							}

							// We create the new Task
							$task->id_statusTask = 1;
							$newTask = $task->replicate();

							// Depending of the type of Assignment, we update id_employee on the task. The default is null
							$id_employee = null;
							// If it is the user executing the current Task							
							if ($id_typesAssignment == 1)
							{
								$id_employee = Auth::user()->id_employee;
							}
							elseif ($id_typesAssignment == 2)
							{
								// TO BE COMPLETED LATER
								//$id_employee = Helper::getSupervisor(Auth::user()->id);
							}
							elseif ($id_typesAssignment == 3)
							{
								// TO BE COMPLETED LATER
								//$id_employee = Helper::getEmployeeNext($id);
							}
							// Update the new Task
							if ($expiration != 'none')
							{
								$date = new DateTime();
								if ($expiration == 'weeks')
								{
									date_add($date, date_interval_create_from_date_string($expiration_value * 7 . ' days'));
								}
								elseif ($expiration == 'hours')
								{
									date_add($date, date_interval_create_from_date_string($expiration_value . ' hours'));
								}
								elseif ($expiration == 'days')
								{
									date_add($date, date_interval_create_from_date_string($expiration_value . ' days'));
								}
								elseif ($expiration == 'months')
								{
									date_add($date, date_interval_create_from_date_string($expiration_value . ' months'));
								}
								elseif ($expiration == 'years')
								{
									date_add($date, date_interval_create_from_date_string($expiration_value . ' years'));
								}
								$newTask->expirationDate = $date;
							}
							$newTask->id_activitiesProcess = $value->id_nextActivity;
							$newTask->id_employee = $id_employee;
							$result = $newTask->save();
							if (!$result)
							{
								return Redirect::route($modelName. '.edit', $id)
													->withInput()
													->with('message', trans('ui.thisTaskCantAdvance'));
							}
							// Finish the current task
							$task->id_statusTask = 2;
							$task->save();

							// If the process has defined audit, we save all the history for the data within _data_
							if ($audit == 'Yes')
							{
								$dataAudit = DB::table($tableName)
												->where('id_task', '=', $id)
												->whereRaw(DB::raw($value->logic))
												->first();
								$dataAudit['id'] = null;
								$dataAudit['id_task'] = $newTask->id;

								// We first update the record with the information, saving id_employee and id_task
								$result = DB::table($tableName)->insert($dataAudit);
								if (!$result)
								{
									return Redirect::route($modelName. '.edit', $id)
														->withInput()
														->with('message', trans('ui.couldntInsertAudit'));
								}
							}

							// If the process has defined log, we save all the information in logs
							if ($log == 'Yes')
							{
								// TO BE COMPLETED LATER
								// We insert a record with the transaction
							}

							// We update the fields for _data_ and task for the fields on fieldsMapping						
							// TO BE COMPLETED LATER
							// Update Data
						}
					}
					else
					{
						// We count the times it has failed
						$countNotSatisfied++;
					}
				}
				// If the instance didn't satisfy any logic and it is not at the End of the process
				// show the message of error
				if ($rules->count() == $countNotSatisfied && $rules->count() > 0)
				{
					return Redirect::route($modelName. '.edit', $id)
										->withInput()
										->with('message', trans('ui.thisTaskCantAdvance'));
				}
			}
			else
			{
				return Redirect::route($modelName. '.edit', $id)
									->withInput()
									->with('message', trans('ui.thereWasErrorProcessing'));
			}
		}
		else
		{
			return Redirect::route($modelName. '.edit', $id)
								->withInput()
								->with('message', trans('ui.thereWasErrorProcessing'));
		}
		return Redirect::route($modelName. '.index')
							->with('information', trans('ui.taskSuccessfullyExecuted'));		
	}

	public function terminate()
	{	
		$modelName = Session::get('modelName');	
		$id = Input::get('id');
		// If Editing			
		if ($id)	
			// Save the information
			$result = self::updateAll($id);
		else
		{
			dd(Input::all());
			$result = self::storeAll($id_activitiesProcess, $tableName);
		}
		if (!$result)
		{
			return Redirect::route($modelName. '.edit', $id)
						->withInput()
						->with('message', trans('ui.couldNotSaveData'));
		}
		$task = Task::find($id);
		$id_statusTask = $task->id_statusTask;
		$id_instance = $task->id_instance;
		$id_activitiesProcess = $task->id_activitiesProcess;

		// If the status of the task is Executed , show the message and go back
		if ($id_statusTask == 2)
		{
			return Redirect::route($modelName. '.edit', $id)
								->withInput()
								->with('message', trans('ui.thisTaskHasBeenPreviouslyExecuted'));
		}
		// If the status of the task is Terminated , show the message and go back
		elseif ($id_statusTask == 3)
		{
			return Redirect::route($modelName. '.edit', $id)
								->withInput()
								->with('message', trans('ui.thisTaskHasBeenTerminated'));
		}		
		// If the status of the task is Pending , we can process the Task
		elseif ($id_statusTask == 1)
		{
			$instance = Instance::where('id', '=', $id_instance)
									->first();

			// Getting Instance information
			$id_statusInstance = $instance->id_statusInstance;					

			// If the status of the Instance is Executed, show the message and go back
			if ($id_statusInstance == 2)
			{
				return Redirect::route($modelName. '.edit', $id)
									->withInput()
									->with('message', trans('ui.thisInstanceHasBeenExecuted'));
			}
			// If the status of the Instance is Terminated, show the message and go back
			elseif ($id_statusInstance == 3)
			{
				return Redirect::route($modelName. '.edit', $id)
									->withInput()
									->with('message', trans('ui.thisInstanceHasBeenTerminated'));
			}
			// If the status of the Instance is On Hold, show the message and go back
			elseif ($id_statusInstance == 4)
			{
				return Redirect::route($modelName. '.edit', $id)
									->withInput()
									->with('message', trans('ui.thisInstanceIsOnHold'));
			}
			// If the status of the Instance is Locked, show the message and go back
			elseif ($id_statusInstance == 5)
			{
				return Redirect::route($modelName. '.edit', $id)
									->withInput()
									->with('message', trans('ui.thisInstanceIsLocked'));
			}
			// If the status of the instance is Pending , we can process the Task
			elseif ($id_statusInstance == 1)
			{
				$activitiesProcess = ActivitiesProcess::where('id', '=', $id_activitiesProcess)
														->first();
				$id_process = $activitiesProcess->id_process;
				$id_activity = $activitiesProcess->id_activity;
				$id_typesAssignment = $activitiesProcess->id_typesAssignment;

				$process =  Process::where('id', '=', $id_process)
										->where('isActive', '=', 'Yes')
										->first();					

				$id_finalActivity = $process->id_finalActivity;
				$id_metaData = $process->id_metaData;
				$audit = $process->audit;
				$log = $process->log;

				// We get the name of the _data_ table with the metaData
				$tableName = '_data_' . $id_metaData;

				// For each rule in the table we execute our logic on our _data_ table
				if ($audit == 'Yes')
				{
					$data = DB::table($tableName)
								->where('id_task', '=', $id)
								->first();
				}
				else
				{
					$data = DB::table($tableName)
								->where('id_instance', '=', $id_instance)
								->first();
				}

				if ($data)
				{						
					// We update the status for Termination
					$task->id_statusTask = 3;
					$task->save();

					// If the instance has non Pending task, we finish the instance	
					$otherTasks = Task::where('id_instance', '=', $task->id_instance)
										->where('id_statusTask', '=', 1)
										->get();
					if (!$otherTasks->count())
					{
						// We update status for the Instance to Terminated
						$instance = Instance::find($task->id_instance);
						$instance->id_statusInstance = 3;
						$instance->save();
					}

					// If the process has defined audit, we save all the history for the data within _data_
					if ($audit == 'Yes')
					{
						$dataAudit = DB::table($tableName)
										->where('id_task', '=', $id)
										->whereRaw(DB::raw($value->logic))
										->first();
						$dataAudit['id'] = null;
						$dataAudit['id_task'] = $newTask->id;

						// We first update the record with the information, saving id_employee and id_task
						$result = DB::table($tableName)->insert($dataAudit);
						if (!$result)
						{
							return Redirect::route($modelName. '.edit', $id)
												->withInput()
												->with('message', trans('ui.couldntInsertAudit'));
						}
					}

					// If the process has defined log, we save all the information in logs
					if ($log == 'Yes')
					{
						// TO BE COMPLETED LATER
						// We insert a record with the transaction
					}

					// We update the fields for _data_ and task for the fields on fieldsMapping						
					// TO BE COMPLETED LATER
					// Update Data
				}
			}
			else
			{
				return Redirect::route($modelName. '.edit', $id)
									->withInput()
									->with('message', trans('ui.thereWasErrorProcessing'));
			}
		}
		else
		{
			return Redirect::route($modelName. '.edit', $id)
								->withInput()
								->with('message', trans('ui.thereWasErrorProcessing'));
		}
		return Redirect::route($modelName. '.index')
							->with('information', trans('ui.taskSuccessfullyTerminated'));		
	}

	public function destroy($id)
	{
		$modelName = Session::get('modelName');	
		$dateTime = new \DateTime;

		$task = Task::where('id', '=', $id)
					->first();

		if ($task)
		{
			$instance = Instance::find($task->id_instance);
			$instance->deleted_at = $dateTime;

			$activitiesProcess = ActivitiesProcess::where('id', '=', $task->id_activitiesProcess)
													->first();
			if ($activitiesProcess)
			{
				$process = Process::where('id', '=', $activitiesProcess->id_process)
										->first();
				if ($process)
				{
					$tableName = '_data_' . $process->id_metaData;
					$affectedRows = Task::where('id_instance', '=', $task->id_instance)->update(array('deleted_at' => $dateTime));
					$instance->save();
					DB::table($tableName)->where('id_instance', '=', $task->id_instance)
										->update(array('deleted_at' => $dateTime));
					return Redirect::route($modelName. '.index');
				}
			}
		}
		return Redirect::route($modelName. '.index')
						->with('message', trans('ui.couldNotDeleteTask'));

	}

	public function fulltextSearch()
	{
		$term = Input::get('term');
		$tableName = Input::get('table');
		$type = Input:: get('type');
		$modelName = ucfirst(str_singular($tableName));
		$entity = new $modelName;
		$data = array_except(Input::all(), array('table', 'term', 'type'));

		if ($type == 'default')
		{
			$mainSearchFields = implode(',', $entity->arraySearchFields);
			$autocomplete = $entity->autocomplete;
			// $mainField = $entity->fieldName;
			// if (isset($entity->fieldNameAux))
			// 	$mainFieldAux = $entity->fieldNameAux;
			// else
			// 	$mainFieldAux = null;
			// if (isset($entity->fieldTextAux))
			// 	$mainTextAux = $entity->fieldTextAux;
			// else
			// 	$mainTextAux = null;

		    $results = DB::table($tableName)->select($tableName . '.*');
		    $searchFields = '';
		    foreach ($data as $field => $info)
		    {
		    	$table = strstr($info, '-', true);
		    	$value = substr(strstr($info, '-'),1);
				$modelNameAux = ucfirst(str_singular($table));
				$entityAux = new $modelNameAux;
				if ($entityAux->isSoftDeleting())
			   		$results = $results->whereNull($table . '.deleted_at');
		   		$results = $results->join($table, $tableName . '.id', '=', $table . '.id_' . str_singular($tableName))
		   							->where($table . '.' . $field, '=', $value);
		   	}
			if ($entity->isSoftDeleting())
		   		$results = $results->whereNull($tableName . '.deleted_at');
		   	if ($term != '  ')
			{
			   	if (Session::get('__mysqlVersion') >= 5.6)
			   	{			
				   	$results = $results->where(function($query) use ($mainSearchFields, $term, $data)
										{
											$query->whereRaw("MATCH(" . $mainSearchFields . ") AGAINST('+{$term}*' IN BOOLEAN MODE)");
											foreach	($data as $field => $info)
											{						
			    								$table = strstr($info, '-', true);
												$modelName = ucfirst(str_singular($table));
												$entityTemp = new $modelName;
												$searchFields = implode(',', $entityTemp->arraySearchFields);
												$query = $query->orWhereRaw("MATCH(" . $searchFields . ") AGAINST('+{$term}*' IN BOOLEAN MODE)");
											}
										});
				}
				else
				{
					$searchFields = $entity->arraySearchFields;
					$mainSearchTermBits = array();
					foreach ($searchFields as $field)
					{
					    $field = trim($field);
					    if (!empty($field)) {
					        $mainSearchTermBits[] = $field . " LIKE '%$term%'";
					    }
					}

				   	$results = $results->where(function($query) use ($mainSearchTermBits, $term, $data)
											{
												$query->whereRaw(implode(' OR ', $mainSearchTermBits));
												foreach	($data as $field => $info)
												{						
				    								$table = strstr($info, '-', true);
													$modelName = ucfirst(str_singular($table));
													$entityTemp = new $modelName;

													$searchFields = $entityTemp->arraySearchFields;
													$searchTermBits = array();
													foreach ($searchFields as $field)
													{
													    $field = trim($field);
													    if (!empty($field)) {
													        $searchTermBits[] = $field . " LIKE '%$term%'";
													    }
													}
													$query = $query->orWhereRaw(implode(' OR ', $searchTermBits));
												}
											});
				}
			}
		    $results = $results->limit(Session::get('_maxAutocompleteRows'));
		    $results = $results->get();
			$rows = array();
			if ($results)
			{
				foreach ($results as $index => $value)
				{
					$content = '';
					$lastContent = '';
					foreach ($autocomplete as $key => $element)
					{
						$info = substr(strstr($element, ':'),1);
						$type = strstr($element, ':', true);
						if ($type == 'field')
						{
							if ($value->$info == '' || $value->$info == null)
								$content = $lastContent;
							else
							{
								$lastContent = $content;
								$content = $content . $value->$info;
							}
						}
						elseif ($type == 'text')
						{
							$lastContent = $content;
							$content = $content . $info;
						}
						elseif ($type == 'linked')
						{
							$table = strstr($info, '=', true);
							if ($table)
							{
								$remaining = substr(strstr($info, '='),1);
								$field = substr(strstr($remaining, ' '),1);
								if ($field)
								{
									$id = strstr($remaining, ' ', true);
									$results = DB::table($table)
														->where($id, '=', $value->id)
														->get();
									if (count($results) == 1)
									{
										$fieldName = $field;
										$result = $results[0];								
										if ($result->$fieldName == '' || $result->$fieldName == null)
											$content = $lastContent;
										else
										{
											$lastContent = $content;
											$content = $content . $result->$fieldName;
										}
									}
									else
									{
										$content = $lastContent;
									}
								}
								else
								{
									$id = $remaining;
									$results = DB::table($table)
														->where($id, '=', $value->id)
														->get();
									if (count($results) == 1)
									{
										$entityName = ucfirst(substr(strstr($id, '_'),1));
										$entityObject = new $entityName;
										$fieldName = $entityObject->fieldName;
										$result = $results[0];
										if ($result->$fieldName == '' || $result->$fieldName == null)
											$content = $lastContent;
										else
										{
											$lastContent = $content;
											$content = $content . $result->$fieldName;
										}
									}
								}
							}
							else
							{
								$field = substr(strstr($info, ' '),1);
								if ($field)
								{
									$id = strstr($info, ' ', true);
									$table = str_plural(substr(strstr($id, '_'),1));
									$results = DB::table($table)
														->where('id', '=', $value->$id)
														->get();
									if (count($results) == 1)
									{
										$fieldName = $field;
										$result = $results[0];								
										if ($result->$fieldName == '' || $result->$fieldName == null)
											$content = $lastContent;
										else
										{
											$lastContent = $content;
											$content = $content . $result->$fieldName;
										}
									}
									else
									{
										$content = $lastContent;
									}
								}
								else
								{
									$id = $info;
									$table = str_plural(substr(strstr($id, '_'),1));
									$results = DB::table($table)
														->where('id', '=', $value->$id)
														->get();
									if (count($results) == 1)
									{
										$entityName = ucfirst(substr(strstr($id, '_'),1));
										$entityObject = new $entityName;
										$fieldName = $entityObject->fieldName;
										$result = $results[0];								
										if ($result->$fieldName == '' || $result->$fieldName == null)
											$content = $lastContent;
										else
										{
											$lastContent = $content;
											$content = $content . $result->$fieldName;
										}
									}
								}
							}
 						}
						else
						{
							// Error
							$content = $type; //'Error in autocomplete array';
						}
						// if ($mainFieldAux && $value->$mainFieldAux)
						// 	$content =  $value->$mainField . $mainTextAux . $value->$mainFieldAux;
						// else
						// 	$content =  $value->$mainField;
					}
					$rows[] = array (
						'id'	=> $value->id,
						'value'	=> $content);
				}
			}
			return json_encode($rows);
		}
		else
			return $entity->fulltextSearch($tableName, $term, $data);
	}

	public function updateDropDown()
	{
		$table = Input::get('table');
		$field = Input::get('field');
		$idField = Input::get('idField');
		$value = Input::get('value');

		// Get table from field
    	$mainTable = str_plural(substr(strstr($idField, '_'),1));
    	if ($mainTable == $table)
    	{
			$results = DB::table($table)
								->where($field, '=', $value)
								->where('isActive', '=', 'Yes')
								->whereNull('deleted_at')
								->get();
			$rows = array();
			if ($results)
			{
				foreach ($results as $index => $value)
				{
					$rows[] = array (
						'id'	=> $value->id,
						'value'	=> $value->name);
				}
			}
		}
		else
		{
    		// If it is different do a join
		    $results = DB::table($mainTable)->select($mainTable . '.*')
		    					->join($table, $mainTable . '.id', '=', $table . '.id_' . str_singular($mainTable))
	   							->where($table . '.' . $field, '=', $value)
								->where($mainTable . '.isActive', '=', 'Yes')
								->whereNull($mainTable . '.deleted_at')
								->get();

			// Get the default main field of the table
			$modelName = ucfirst(str_singular($mainTable));
			$entity = new $modelName;
			$mainField = $entity->fieldName;

			$rows = array();
			if ($results)
			{
				foreach ($results as $index => $value)
				{
					if (isset($entity->auxName))
					{
						$auxField = $entity->auxName;
						$rows[] = array (
							'id'	=> $value->id,
							'value'	=> $value->$mainField . ' ' . $value->$auxField);
					}
					else
					{
						$rows[] = array (
							'id'	=> $value->id,
							'value'	=> $value->$mainField);
					}
				}
			}
		}
		return json_encode($rows);
	}

	public function getTasks()
	{
		$modelName = Session::get('modelName');	

		if (Session::has('searchField'))
			$input = Session::get('searchField');
		else
			$input = "";

		if (Auth::user()->id == 1)
		{
			$id_organization = Session::get('id_organizationSelected');		
			if (!$id_organization)
				$id_organization = Session::get('id_organization');
		}
		else
		{
			$id_organization = Auth::user()->id_organization;
			Session::put('id_organization', $id_organization);
		}

		// Pull all the campaigns for the id_organization selected
		$campaigns = Helper::loadCampaigns(Auth::user()->id_employee, 4, 1);
		$arrayTemp = array('0'=>'All Campaigns');
		$campaigns = $arrayTemp + $campaigns;
		$id_campaign = Session::get('id_campaignSelected');
		if (!$id_campaign)
		{
			reset($campaigns);
			$id_campaign = key($campaigns);
		}

		// Collaborators
		$collaborators = Helper::loadCollaborators(Auth::user()->id_employee, 4, 1);
		if (count($collaborators) > 1)
		{
			$id_employee = Session::get('id_employeeSelected');		
			if (!$id_employee)
				$id_employee = Auth::user()->id_employee;
			else
				$id_employee = 0;
		}
		else
			$id_employee = Auth::user()->id_employee;
	
		$task = new Task;
		$arraySearchFields = $task->arraySearchFields;		

		if (Session::has('id_statusTask'))
			$id_statusTask = Session::get('id_statusTask');
		else
			$id_statusTask = 1;

		if (Session::has('id_activitiesProcess'))
			$id_activitiesProcess = Session::get('id_activitiesProcess');
		else
			$id_activitiesProcess = 1;

		if (Session::has('id_day'))
			$id_day = Session::get('id_day');
		else
			$id_day = 1;

		$to = new DateTime();
		date_add($to, date_interval_create_from_date_string($id_day . ' days'));
		$to = new DateTime(date_format($to, 'Y-m-d'));

		$modelData = $this->model->select('tasks.id', DB::raw("CASE WHEN activitiesProcesses.id_activity = processes.id_initialActivity THEN 'Yes' ELSE 'No' END as isFirstActivity"), DB::raw('DATE_FORMAT(least(coalesce(dueDate, expirationDate), coalesce(expirationDate,dueDate)), "%Y-%m-%d %H:%i") as dueDate'), DB::raw("CASE WHEN dueDate < now() THEN 1 WHEN date(dueDate) = date(now()) THEN 2 ELSE 0 END as isUrgent"), 'tasks.notes', 'tasks.summary', 'tasks.reference', 'tasks.id_activitiesProcess', 'tasks.id_employee', 'tasks.id_statusTask', 'addresses.latitude as lat', 'addresses.longitude as lon', 'tasks.isAppointment as isAppointment')
								->join('instances', 'tasks.id_instance', '=', 'instances.id')
								->join('_data_1', '_data_1.id_instance', '=', 'instances.id')
								->join('addresses', '_data_1.id_address', '=', 'addresses.id')
								->join('activitiesProcesses', 'tasks.id_activitiesProcess', '=', 'activitiesProcesses.id')
								->join('processes', 'processes.id', '=', 'activitiesProcesses.id_process');
		if ($id_activitiesProcess)
			$modelData = $modelData->where('tasks.id_activitiesProcess', '=', $id_activitiesProcess);

		if ($id_statusTask)
			$modelData = $modelData->where('tasks.id_statusTask', '=', $id_statusTask);

		if ($id_day)
			$modelData = $modelData->where(function($query) use ($to)
								{
									$query->where('tasks.dueDate', '<=', $to)
											->orWhere('tasks.expirationDate', '<=', $to)
											->orWhereRaw(DB::raw('least(coalesce(dueDate, expirationDate), coalesce(expirationDate,dueDate)) IS NULL'));
									});

		$modelData = $modelData->where(function($query) use ($id_employee)
								{
									if ($id_employee > 0)
										$query->where('tasks.id_employee', '=', $id_employee);
								})
								->where(function($query) use ($id_organization)
								{
									if ($id_organization > 0)
										$query->where('processes.id_organization', '=', $id_organization);
								})
								->where(function($query) use ($id_campaign)
								{
									if ($id_campaign > 0)
										$query->where('processes.id_campaign', '=', $id_campaign);
								})
								->where(function($query) use ($input, $arraySearchFields, $modelName)
								{
									$query->where('processes.name', 'LIKE', '%'.$input.'%');
									foreach ($arraySearchFields as $term)
									{
										if ($term != 'name')
											$query->orWhere('tasks.' . $term, 'LIKE', '%'.$input.'%');
									}
								})
								//->orderBy(DB::raw('dueDate IS NULL'))
								->orderBy(DB::raw('dueDate'), 'ASC')
								->orderBy('tasks.id', 'DSC')
								->get();

		$rows = array();
		if ($modelData)
		{
			foreach ($modelData as $index => $value)
			{
				$rows[] = array (
					'id'			=> $value->id,
					'lat'			=> $value->lat,
					'lon'			=> $value->lon,
					'isAppointment'	=> $value->isAppointment,
					'dueDate'		=> $value->dueDate,
					'summary'		=> $value->summary,
					'reference'		=> $value->reference);
			}
		}
		return json_encode($rows);
    }




	public function loadAssistantDropDown()
	{
		// earth's mean radius in miles
		$earthRadius = 3959;
		// radius of search from the current position in miles
		$radius = 0.1;

		$lat = Input::get('lat');
		$lon = Input::get('lon');

	    $latRad = deg2rad($lat); 
	    $lonRad = deg2rad($lon); 

		// Get the list of places nearby
		$sensor = 'true';
		$apiKey = 'AIzaSyBG2TgRGJVMzzTFHpAmj-PxDINOnxtB-5w';
		$pagetoken = '';
		$rankby = 'distance';
		$radiusMeters = 1609.34 * $radius;
		$types = "accounting|airport|amusement_park|aquarium|art_gallery|atm|bakery|bank|bar|beauty_salon|bicycle_store|book_store|bowling_alley|bus_station|cafe|campground|car_dealer|car_rental|car_repair|car_wash|casino|cemetery|church|city_hall|clothing_store|convenience_store|courthouse|dentist|department_store|doctor|electrician|electronics_store|embassy|establishment|finance|fire_station|florist|food|funeral_home|furniture_store|gas_station|general_contractor|grocery_or_supermarket|gym|hair_care|hardware_store|health|hindu_temple|home_goods_store|hospital|insurance_agency|jewelry_store|laundry|lawyer|library|liquor_store|local_government_office|locksmith|lodging|meal_delivery|meal_takeaway|mosque|movie_rental|movie_theater|moving_company|museum|night_club|painter|park|parking|pet_store|pharmacy|physiotherapist|place_of_worship|plumber|police|post_office|real_estate_agency|restaurant|roofing_contractor|rv_park|school|shoe_store|shopping_mall|spa|stadium|storage|store|subway_station|synagogue|taxi_stand|train_station|travel_agency|university|veterinary_care|zoo";
		$results = Helper::getNearbyPlaces($lat, $lon, $radiusMeters, $sensor, $apiKey, $pagetoken, $rankby, $types);
		if ($results)
		{
			foreach ($results['results'] as $key => $value)
			{
				$geometry = $value['geometry'];
				if (!isset($geometry['viewport']))
				{
					$types = implode(", ",$value['types']);
					
					$latitudePlace = $geometry['location']['lat'];
					$longitudePlace = $geometry['location']['lng'];
					$distance = acos(sin($latRad)*sin(deg2rad($latitudePlace)) + cos($latRad)*cos(deg2rad($latitudePlace))*cos(deg2rad($longitudePlace)-($lonRad))) * $earthRadius;
					$assistantAddressArray[] = array('id_address' => 0, 'id_business' => 0, 'name' => $value['name'], 'vicinity' => $value['vicinity'], 'lat' => $value['geometry']['location']['lat'], 'lon' => $value['geometry']['location']['lng'], 'types' => $types, 'distance' => $distance, 'text' => substr($value['vicinity'],0,11) . '...=>' . $value['name'] . ' (' . $types . ')');
				}	
			}
		}		
		// We add the ones from the database
			// first-cut bounding box (in degrees)
		$maxLat = $lat + rad2deg($radius/$earthRadius);
		$minLat = $lat - rad2deg($radius/$earthRadius);
		// compensate for degrees longitude getting smaller with increasing latitude
		$maxLon = $lon + rad2deg($radius/$earthRadius/cos(deg2rad($lat)));
		$minLon = $lon - rad2deg($radius/$earthRadius/cos(deg2rad($lat)));

		$nearbyAddresses = Address::whereBetween('latitude', array($minLat, $maxLat))
									->whereBetween('longitude', array($minLon, $maxLon))
									->lists('id');

		if (count($nearbyAddresses)>0)
		{
			$nearbyCircle = DB::table('addresses')
								->select(DB::raw('addresses.id as id_address, addressLine1, suite, cities.name as city, businesses.id as id_business, businesses.name as business, businesses.description as description, latitude, longitude, acos(sin(' . $latRad . ')*sin(radians(latitude)) + cos(' . $latRad . ')*cos(radians(latitude))*cos(radians(longitude) - (' . $lonRad . '))) * ' . $earthRadius . ' As distance'))
								->join('cities', 'cities.id', '=', 'addresses.id_city')
								->join('locations', 'locations.id_address', '=', 'addresses.id')
								->join('businesses', 'locations.id_business', '=', 'businesses.id')
								->whereIn('addresses.id', $nearbyAddresses)
								->whereRaw(DB::raw('acos(sin(' . $latRad . ')*sin(radians(latitude)) + cos(' . $latRad . ')*cos(radians(latitude))*cos(radians(longitude) - (' . $lonRad . '))) * ' . $earthRadius . ' <= ' . $radius))
								->orderBy('distance', 'ASC')
								->get();
		}
		else
			$nearbyCircle = array();
		
		foreach($nearbyCircle as $key => $value)
		{
			// Search in assistantAddressArray if it exists
			$founded = false;
			foreach($assistantAddressArray as $k => $v)
			{
				if (strtolower($v['name']) == strtolower($value->business))
				{
					$v['id_business'] = $value->id_business;
					$v['id_address'] = $value->id_address;
					$v['text'] = substr($value->addressLine1 . ' #' . $value->suite . ', ' . $value->city,0,11) . '...=' . $value->business . ' (' . $value->description . ')';
					$assistantAddressArray[$k] = $v;

					// Update id_address y id_business en $nearbyAddresses
					$founded = true;
					// Stop searching for more items
					break;
				}
			}								
			if (!$founded)
		 	{
				// Add the business
				$assistantAddressArray[] = array('id_address' => $value->id_address, 'id_business' => $value->id_business, 'name' => $value->business, 'vicinity' => $value->addressLine1 . ' #' . $value->suite . ', ' . $value->city, 'lat' => $value->latitude, 'lon' => $value->longitude, 'types' => $value->description, 'distance' => $value->distance, 'text' => substr($value->addressLine1 . ' #' . $value->suite . ', ' . $value->city,0,11) . '...=' . $value->business . ' (' . $value->description . ')');
			}
		}

		// We reorder by distance
		$assistantAddressArray = array_values(array_sort($assistantAddressArray, function($value)
		{
		    return $value['distance'];
		}));

		Session::put('lastAddressArray', $assistantAddressArray);

		// We add the last Address
		if (Session::has('lastAddress'))
			array_unshift($assistantAddressArray, array('id_address' => 0, 'id_business' => 0, 'name' => 'Last address', 'vicinity' => Session::get('lastAddress'), 'types' => null, 'distance' => 0, 'text' => Session::get('lastAddress') . '=>' . 'Last address'));

		// We add the current location
		try {
			$geocode = Geocoder::reverse($lat, $lon);
			if ($lat || $lon)
				array_unshift($assistantAddressArray, array('id_address' => 0, 'id_business' => 0, 'name' => 'This location', 'vicinity' => $geocode->getStreetNumber() . ' ' . $geocode->getStreetName() . ', ' . $geocode->getCity(), 'lat' => $lat, 'lon' => $lon, 'types' => null, 'distance' => 0, 'text' => $geocode->getStreetNumber() . ' ' . $geocode->getStreetName() . ', ' . $geocode->getCity() . '=>' . 'This location'));
		} catch (\Exception $e) {
		    // Here we will get "The FreeGeoIpProvider does not support Street addresses." ;)
		    $error = $e->getMessage();
		}

		// We add the default option
		array_unshift($assistantAddressArray, array('id_address' => 0, 'id_business' => 0, 'name' => 'Enter your own address below...', 'vicinity' => null, 'types' => null, 'distance' => 0, 'text' => 'Enter your own address below...'));
		
		return json_encode($assistantAddressArray);
	}
}

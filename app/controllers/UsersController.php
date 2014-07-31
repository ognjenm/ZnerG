<?php

class UsersController extends BaseController {

	protected $model;

	public function __construct(User $model)
	{
		$this->model = $model; 
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	/*
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$modelName = Session::get('modelName');	
		$tableName = $modelName;
		$organizations = Organization::lists('name', 'id');
		$recoveryQuestions = RecoveryQuestion::lists('question', 'id');
		$employees = Employee::get()->lists('full_name', 'id');
		$model = 0;
        return View::make($modelName. '.create', compact('modelName', 'tableName', 'organizations', 'recoveryQuestions', 'model', 'employees'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$modelName = Session::get('modelName');	
		$input = Input::all();
		$v = Validator::make($input, User::$rulesAdditional1);
		if ($v->passes())
		{
			$v = Validator::make($input, User::$rulesAdditional2);
			if ($v->passes())
			{
				$v = Validator::make($input, User::$rules);

				if ($v->passes())
				{
					$password = $input['password'];
					$password = Hash::make($password);

					$model = new User();
					$model->username = $input['username'];
					$model->email = $input['email'];
					$model->id_employee = $input['id_employee'];
					$model->alternativeId = $input['alternativeId'];
					$model->password = $password;
					$model->id_organization = $input['id_organization'];
					$model->id_recoveryQuestion = $input['id_recoveryQuestion'];
					$model->answer = $input['answer'];
					$model->isActive = $input['isActive'];
					$model->isSystem = $input['isSystem'];
					unset($model->password_confirmation);
					$model->save();

					return Redirect::route($modelName. '.edit', $model->id)
										->withInput();
				}
			}
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
		$modelName = Session::get('modelName');	
		$tableName = $modelName;
		$model = $this->model->findOrFail($id);
		if (is_null($model) || ($model->id_organization != Session::get('id_organization') && Auth::user()->id != 1))
			return Redirect::route($modelName. '.index');
		$organizations = Organization::lists('name', 'id');
		$recoveryQuestions = RecoveryQuestion::lists('question', 'id');

        return View::make($modelName. '.show', compact('model', 'modelName', 'tableName', 'organizations', 'recoveryQuestions'));
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

		$activatePasswordModal = Input::get('activatePasswordModal');
		$activateRolesModal = Input::get('activateRolesModal');
		$model = $this->model->find($id);
		if (is_null($model) || ($model->id_organization != Session::get('id_organization') && Auth::user()->id != 1))
			return Redirect::route($modelName. '.index');

		$organizations = Organization::lists('name', 'id');
		$recoveryQuestions = RecoveryQuestion::lists('question', 'id');

		$employees = Employee::get()->lists('full_name', 'id');

		$listRoles1 = DB::table('roles')
				      		->select('roles.id as id',
				      				 'roles.name as name',
				      				 DB::raw('null AS startDate'),
				      				 DB::raw('null AS endDate'),
				      				 DB::raw('null AS checked'))
				      		->where('id_organization', '=', $model->id_organization)
				      		->whereNull('deleted_at')				      		
							->where(function ($query) use ($id)
							{
								$roles = DB::table('usersRoles')->select('id_role')->where('id_user', '=', $id)->lists('id_role');
								if (count($roles)>0)
									$query->whereNotIn('roles.id', $roles);
								else
									$query->where('roles.id', '<>', 'roles.id');

				            })
				            ->orderBy('name', 'ASC');
		$listRoles = DB::table('roles')
				      		->select('roles.id as id',
				      				 'roles.name as name',
				      				 'usersRoles.startDate as startDate',
				      				 'usersRoles.endDate as endDate',
				      				 'usersRoles.id_user as checked')
				      		->leftjoin('usersRoles','roles.id', '=', 'usersRoles.id_role')
				      		->where('id_organization', '=', $model->id_organization)      		
				      		->whereNull('deleted_at')				      		
				      		->where('id_user', '=', $id)
				      		->union($listRoles1)
				      		->get();
		
		$listGroups1 = DB::table('groups')
				      		->select('groups.id as id',
				      				 'groups.name as name',
				      				 DB::raw('null AS checked'))
				      		->where('id_organization', '=', $model->id_organization)      		
				      		->whereNull('deleted_at')				      		
							->where(function ($query) use ($id)
							{
								$groups = DB::table('usersGroups')->select('id_group')->where('id_user', '=', $id)->lists('id_group');
								if (count($groups)>0)
									$query->whereNotIn('groups.id', $groups);
								else
									$query->where('groups.id', '<>', 'groups.id');

				            })
				            ->orderBy('name', 'ASC');
		$listGroups = DB::table('groups')
				      		->select('groups.id as id',
				      				 'groups.name as name',
				      				 'usersGroups.id_user as checked')
				      		->leftjoin('usersGroups','groups.id', '=', 'usersGroups.id_group')
				      		->where('id_organization', '=', $model->id_organization)      		
				      		->whereNull('deleted_at')				      		
				      		->where('id_user', '=', $id)
				      		->union($listGroups1)
				      		->get();

        return View::make($modelName. '.edit', compact('model', 'modelName', 'tableName', 'organizations', 'recoveryQuestions', 'listRoles', 'listGroups', 'activatePasswordModal', 'activateRolesModal', 'employees'));
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

		$v = Validator::make($input, User::$rulesForEdit);
		if ($v->passes())
		{
			$model = $this->model->find($id);
			$model->update($input);			
			if (Auth::user()->isSystem == 'No')
				return Redirect::to('/main');
			else
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
		if (is_null($model) || ($model->id_organization != Session::get('id_organization') && Auth::user()->id != 1))
			return Redirect::route($modelName. '.index');
		if ($model)
		{
			$model->delete();
			return Redirect::route($modelName. '.index');
		}
		else
			return Redirect::route($modelName. '.index')->with('message', trans('ui.alreadyDeleted'));
	}

	public function getLogin()
	{
		if (Auth::check())
			return View::make('home.main')->with('organization', $organization);			
		else
			return View::make('users.login');
	}

	public function getMain($shortName = null)
	{
		if (is_null($shortName))
		{
			return Redirect::to('/');
		}
		else
		{
			$organization = Organization::where('shortName', '=', $shortName)->first();

			if (is_null($organization))
				return Redirect::to('/');
			else
			{
				Session::put('shortName', $organization->shortName);
				Session::put('id_organization', $organization->id);

				// Check if the user is logged in
				if (Auth::check())
					return View::make('home.main')->with('organization', $organization);
				else
					return View::make('users.login');
			}
		}
	}

	public function postLogin()
	{
		$input = Input::all();
		if (!Session::has('id_organization'))
			return Redirect::to('/')->withInput()->with('message', trans('ui.useValidLinkToAccess'));


		$input['id_organization'] = Session::get('id_organization');
		$v = Validator::make($input, User::$rulesForLogin);

		if($v->fails())
			return Redirect::to('login')->withErrors($v);
		else
		{
			$credentials = array('username' => $input['username'], 'password' => $input['password'], 'id_organization' => $input['id_organization']);
			if(Auth::attempt($credentials))
			{
				if (Auth::user()->isActive == 'No')
				{
					Auth::logout();
					return Redirect::to('login')->withInput()->with('message', trans('ui.userInactive'));
				}				
				Auth::user()->loadMenu();
				return Redirect::to('main');
			}
			else
				return Redirect::to('login')->withInput()->with('message', trans('ui.emailAndPasswordInvalid'));
		}
	}

	public function getRegister()
	{
		$modelName = 'users';	
		$recoveryQuestions = RecoveryQuestion::lists('question', 'id');

		return View::make($modelName . '.register', compact('recoveryQuestions', 'modelName'));
		
	}

	public function postRegister()
	{
		$input = Input::all();
		$input['id_organization'] = Session::get('id_organization');
		$v = Validator::make($input, User::$rulesAdditional1);
		if ($v->passes())
		{
			$v = Validator::make($input, User::$rulesAdditional2);
			if ($v->passes())
			{
				$v = Validator::make($input, User::$rules);

				if ($v->passes())
				{
					$password = $input['password'];
					$password = Hash::make($password);

					$user = new User();
					$user->username = $input['username'];
					$user->email = $input['email'];
					$user->password = $password;
					$user->id_organization = $input['id_organization'];
					$user->id_recoveryQuestion = $input['id_recoveryQuestion'];
					$user->answer = $input['answer'];
					unset($user->password_confirmation);
					$user->save();

					return Redirect::to('login')->with('message', trans('ui.accountCreated'));;			
				}
				else
					return Redirect::to('register')->withInput()->withErrors($v);		
			}
			else
				return Redirect::to('register')->withInput()->withErrors($v);
		}
		else
			return Redirect::to('register')->withInput()->withErrors($v);
	}

	public function logout()
	{
		Auth::logout();

		return $this->getLogin();
	}

	public function assignGroups()
	{
		$modelName = Session::get('modelName');	

		$records = Input::get('records');
		$id = Input::get('id');
		// Delete all assigned users 
		UsersGroup::where('id_user', '=', $id)->delete();

		// Asign selected users
		if (is_array($records))			
		{
			foreach ($records as $key => $value)
			{
				$group = UsersGroup::create(array('id_group' => $value, 'id_user' => $id));
				if (is_null($group))
					return Redirect::route($modelName. '.edit', $id)
										->withInput()
										->with('message', trans('ui.errorCreating') . $modelName);
			}
		}
		return Redirect::route($modelName. '.edit', $id);
	}

	public function assignRoles()
	{
		$modelName = Session::get('modelName');	
		$input = array_except(Input::all(), '_method');

		$records = Input::get('records');
		$id = Input::get('id');

		$usersRole = new UsersRole();
		// Assign selected users
		if (is_array($records))			
		{
			foreach ($records as $key => $value)
			{
				$usersRole->startDate = $input['startDate'.$value];
				$usersRole->endDate = $input['endDate'.$value];
				$v = $usersRole->validate(UsersRole::$rulesDates, array());
				if (!$v)
				{
					Input::merge(array('activateRolesModal' => 'Yes'));
					return Redirect::route($modelName. '.edit', $id)
										->withInput()
										->withErrors($usersRole->errors())
										->with('errorModal', 'Yes');
				}
			}
			// Delete all assigned roles for that user
			UsersRole::where('id_user', '=', $id)->delete();
			foreach ($records as $key => $value)
			{
				if (!isset($input['startDate'.$value]) || $input['startDate'.$value] == "")
					$usersRole->startDate = null;
				else
					$usersRole->startDate = $input['startDate'.$value];
				if (!isset($input['endDate'.$value]) || $input['endDate'.$value] == "")
					$usersRole->endDate = null;
				else
					$usersRole->endDate = $input['endDate'.$value];
				$usersRole->id_role = $value;
				$usersRole->id_user = $id;
				// Create the new one
				$role = UsersRole::create(array('id_role' => $usersRole->id_role, 'id_user' => $usersRole->id_user, 'startDate' => $usersRole->startDate, 'endDate' => $usersRole->endDate));
				if (is_null($role))
				{
					Input::merge(array('activateRolesModal' => 'Yes'));
					return Redirect::route($modelName. '.edit', $id)
										->withInput()
										->withErrors($usersRole->errors())
										->with('errorModal', 'Yes');
				}
			}
		}
		else
		{
			// Delete all assigned roles for that user
			UsersRole::where('id_user', '=', $id)->delete();
		}

		return Redirect::route($modelName. '.edit', $id);
	}

	public function changePassword()
	{
		$modelName = Session::get('modelName');	

		$input = Input::all();
		$id = $input['id'];		
		$v = Validator::make($input, User::$rulesForChangePassword);
		if ($v->passes())
		{
			$model = $this->model->find($id);
			if(is_null($model))
				return Redirect::route($modelName. '.index');

			$password = $input['password'];
			$password = Hash::make($password);
			$model->password = $password;
			$model->save();
			Input::merge(array('activateModal' => ''));
			return Redirect::route($modelName. '.edit', $id)
						->withInput();
		}
		Input::merge(array('activatePasswordModal' => 'Yes'));
		return Redirect::route($modelName. '.edit', $id)
							->withInput()
							->withErrors($v)
							->with('errorModal', 'Yes');
	}

}
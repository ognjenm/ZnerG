<?php

class RolesController extends ArdentController {

	public function __construct(Role $model)
	{
		$this->model = $model;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editDetail()
	{
		$id = Session::get('id');
		$model = $this->model->find($id);
		if(is_null($model))
			return Redirect::route($modelName. '.index');

		$activateUsersModal = Input::get('activateUsersModal');

		$listUsers1 = DB::table('users')
				      		->select('users.id as id',
				      				 'users.username as username',
				      				 'users.id_employee as id_employee',
				      				 'employees.firstName as firstName',
				      				 'employees.lastName as lastName',
				      				 DB::raw('null AS startDate'),
				      				 DB::raw('null AS endDate'),
				      				 DB::raw('null AS checked'))
				      		->leftjoin('employees','users.id_employee', '=', 'employees.id')
				      		->where('users.id_organization', '=', $model->id_organization)      		
							->where(function ($query) use ($id)
							{
								$users = DB::table('usersRoles')->select('id_user')->where('id_role', '=', $id)->lists('id_user');
								if (count($users)>0)
									$query->whereNotIn('users.id', $users);
								else
									$query->where('users.id', '<>', 'users.id');

				            })
				            ->orderBy('username', 'ASC');
		$listUsers = DB::table('users')
				      		->select('users.id as id',
				      				 'users.username as username',
				      				 'users.id_employee as id_employee',
				      				 'employees.firstName as firstName',
				      				 'employees.lastName as lastName',
				      				 'usersRoles.startDate as startDate',
				      				 'usersRoles.endDate as endDate',
				      				 'usersRoles.id_role as checked')
				      		->leftjoin('usersRoles','users.id', '=', 'usersRoles.id_user')
				      		->leftjoin('employees','users.id_employee', '=', 'employees.id')
				      		->where('users.id_organization', '=', $model->id_organization)      		
				      		->where('id_role', '=', $id)
				      		->union($listUsers1)
				      		->get();
		
		$listGroups1 = DB::table('groups')
				      		->select('groups.id as id',
				      				 'groups.name as name',
				      				 DB::raw('null AS checked'))
				      		->where('id_organization', '=', $model->id_organization)      		
				      		->whereNull('deleted_at')
							->where(function ($query) use ($id)
							{
								$groups = DB::table('rolesGroups')->select('id_group')->where('id_role', '=', $id)->lists('id_group');
								if (count($groups)>0)
									$query->whereNotIn('groups.id', $groups);
								else
									$query->where('groups.id', '<>', 'groups.id');
				            })
				            ->orderBy('name', 'ASC');

		$listGroups = DB::table('groups')
				      		->select('groups.id as id',
				      				 'groups.name as name',
				      				 'rolesGroups.id_role as checked')
				      		->leftjoin('rolesGroups','groups.id', '=', 'rolesGroups.id_group')
				      		->where('id_organization', '=', $model->id_organization)      		
				      		->whereNull('deleted_at')
				      		->where('id_role', '=', $id)
				      		->union($listGroups1)
				      		->get();

		$listOptionsWithRole = DB::table('rolesOptions')->select('rolesOptions.id_option')
														->where('rolesOptions.id_role', '=', $id)
														->lists('rolesOptions.id_option');

		$listOptions1 = DB::table('options')
							->select('options.id as id',
									 'options.name as name',
								     DB::raw('0 as authInsert'),
								     DB::raw('0 as authUpdate'),
								     DB::raw('0 as authDelete'),
								     DB::raw('0 as authExecute'))
				      		->leftjoin('rolesOptions','options.id', '=', 'rolesOptions.id_option')
							->where(function ($query) use ($listOptionsWithRole)
							{
								if (count($listOptionsWithRole))
									$query->whereNotIn('options.id', $listOptionsWithRole);
								else
									$query->where('options.id', '<>', 'options.id');
				            })
				            ->orderBy('name', 'ASC');

		$listOptions = DB::table('options')
							->select('options.id as id',
									 'options.name as name',
								     'rolesOptions.insert as authInsert',
								     'rolesOptions.update as authUpdate',
								     'rolesOptions.delete as authDelete',
								     'rolesOptions.execute as authExecute')
				      		->join('rolesOptions','options.id', '=', 'rolesOptions.id_option')
				      		->where('rolesOptions.id_role', '=', $id)
				            ->union($listOptions1)
				      		->get();

        return parent::editDetail()->with('id', $id)
        							->with('listUsers', $listUsers)
        							->with('listGroups', $listGroups)
        							->with('listOptions', $listOptions)
        							->with('activateUsersModal', $activateUsersModal);
	}

	public function assignUsers()
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
					Input::merge(array('activateUsersModal' => 'Yes'));
					return Redirect::route($modelName. '.edit', $id)
										->withInput()
										->withErrors($usersRole->errors())
										->with('errorModal', 'Yes');
				}
			}
			// Delete all assigned users 
			UsersRole::where('id_role', '=', $id)->delete();
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
				$usersRole->id_role = $id;
				$usersRole->id_user = $value;
				// Create the new one
				$role = UsersRole::create(array('id_role' => $usersRole->id_role, 'id_user' => $usersRole->id_user, 'startDate' => $usersRole->startDate, 'endDate' => $usersRole->endDate));
				if (!$role)
				{
					Input::merge(array('activateUsersModal' => 'Yes'));
					return Redirect::route($modelName. '.edit', $id)
										->withInput()
										->withErrors($usersRole->errors())
										->with('errorModal', 'Yes');
				}
			}
		}
		else
		{
			// Delete all assigned users 
			UsersRole::where('id_role', '=', $id)->delete();
		}
		//dd('Stop');
		return Redirect::route($modelName. '.edit', $id);
	}

	public function assignGroups()
	{
		$modelName = Session::get('modelName');	

		$records = Input::get('records');
		$id = Input::get('id');
		// Delete all assigned roles 
		RolesGroup::where('id_role', '=', $id)->delete();

		// Asign selected roles
		if (is_array($records))			
		{
			foreach ($records as $key => $value)
			{
				$group = RolesGroup::create(array('id_group' => $value, 'id_role' => $id));
				if (is_null($group))
					return Redirect::route($modelName. '.edit', $id)
										->withInput()
										->with('message', trans('ui.errorCreating') . $modelName);
			}
		}
		return Redirect::route($modelName. '.edit', $id);
	}

	public function assignOptions()
	{
		$modelName = Session::get('modelName');	

		$records = Input::get('records');
		$id = Input::get('id');
		// Delete all assigned roles 
		DB::table('rolesOptions')->where('id_role', '=', $id)->delete();

		// Asign selected roles
		if (is_array($records))			
		{
			foreach ($records as $key => $value)
			{
				$text = substr($value, 0, 6);	
				$value = substr($value, 6);
				switch ($text) {
				    case 'execut':
						$item = DB::table('rolesOptions')->where('id_role', '=', $id)
									  		  		   ->where('id_option', '=', $value)
										  	      	   ->update(array('execute' => 1));
						if (!$item)
							$item = DB::table('rolesOptions')->insert(array('id_option' => $value, 'id_role' => $id, 'execute' => 1));
				        break;
				    case 'insert':
						$item = DB::table('rolesOptions')->where('id_role', '=', $id)
									  		  		   ->where('id_option', '=', $value)
										  	      	   ->update(array('insert' => 1));
						if (!$item)
							$item = DB::table('rolesOptions')->insert(array('id_option' => $value, 'id_role' => $id, 'insert' => 1));
				        break;
				    case 'update':
						$item = DB::table('rolesOptions')->where('id_role', '=', $id)
									  		  		   ->where('id_option', '=', $value)
										  	      	   ->update(array('update' => 1));
						if (!$item)
							$item = DB::table('rolesOptions')->insert(array('id_option' => $value, 'id_role' => $id, 'update' => 1));
				        break;
				    case 'delete':
						$item = DB::table('rolesOptions')->where('id_role', '=', $id)
									  		  		   ->where('id_option', '=', $value)
										  	      	   ->update(array('delete' => 1));
						if (!$item)
							$item = DB::table('rolesOptions')->insert(array('id_option' => $value, 'id_role' => $id, 'delete' => 1));
				        break;
				}
			}
		}
		return Redirect::route($modelName. '.edit', $id);
					
	}


}

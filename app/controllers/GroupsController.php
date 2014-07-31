<?php

class GroupsController extends ArdentController {

	public function __construct(Group $model)
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
		$modelName = Session::get('modelName');
		$id = Session::get('id');
		$model = $this->model->find($id);

		if(is_null($model))
			return Redirect::route($modelName. '.index');

		$users = DB::table('usersGroups')->select('id_user')->where('id_group', '=', $id)->lists('id_user');
		$roles = DB::table('rolesGroups')->select('id_role')->where('id_group', '=', $id)->lists('id_role');

		$listUsers1 = DB::table('users')
				      		->select('users.id as id',
				      				 'users.username as username',
				      				 'users.id_employee as id_employee',
				      				 DB::raw('null AS checked'),
				      				 DB::raw('null AS fullName'))
				      		->where('id_organization', '=', $model->id_organization)
							->where(function ($query) use ($id, $users)
							{								
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
				      				 'usersGroups.id_group as checked',
				      				 DB::raw('concat(firstName, " ", lastName) as fullName'))
				      		->leftjoin('usersGroups','users.id', '=', 'usersGroups.id_user')
				      		->leftjoin('employees','users.id_employee', '=', 'employees.id')
				      		->where('users.id_organization', '=', $model->id_organization)      		
				      		->where('id_group', '=', $id)
				      		->union($listUsers1)
				      		->get();
		
		$listRoles1 = DB::table('roles')
				      		->select('roles.id as id',
				      				 'roles.name as name',
				      				 DB::raw('null AS checked'))
				      		->where('id_organization', '=', $model->id_organization)      		
				      		->whereNull('deleted_at')
							->where(function ($query) use ($id, $roles)
							{
								if (count($roles)>0)
									$query->whereNotIn('roles.id', $roles);
								else
									$query->where('roles.id', '<>', 'roles.id');
				            })
				            ->orderBy('name', 'ASC');
		$listRoles = DB::table('roles')
				      		->select('roles.id as id',
				      				 'roles.name as name',
				      				 'rolesGroups.id_group as checked')
				      		->leftjoin('rolesGroups','roles.id', '=', 'rolesGroups.id_role')
				      		->where('id_organization', '=', $model->id_organization)      		
				      		->whereNull('deleted_at')
				      		->where('id_group', '=', $id)
				      		->union($listRoles1)
				      		->get();

        return parent::editDetail()->with('id', $id)
        							->with('listUsers', $listUsers)
        							->with('listRoles', $listRoles);
	}

	public function assignUsers()
	{
		$modelName = Session::get('modelName');	

		$records = Input::get('records');
		$id = Input::get('id');
		// Delete all assigned users 
		UsersGroup::where('id_group', '=', $id)->delete();

		// Asign selected users
		if (is_array($records))			
		{
			foreach ($records as $key => $value)
			{
				$user = UsersGroup::create(array('id_user' => $value, 'id_group' => $id));
				if (is_null($user))
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

		$records = Input::get('records');
		$id = Input::get('id');
		// Delete all assigned roles 
		RolesGroup::where('id_group', '=', $id)->delete();

		// Asign selected roles
		if (is_array($records))			
		{
			foreach ($records as $key => $value)
			{
				$role = RolesGroup::create(array('id_role' => $value, 'id_group' => $id));
				if (is_null($role))
					return Redirect::route($modelName. '.edit', $id)
										->withInput()
										->with('message', trans('ui.errorCreating') . $modelName);
			}
		}
		return Redirect::route($modelName. '.edit', $id);
	}
}

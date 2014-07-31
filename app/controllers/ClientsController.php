<?php

class ClientsController extends ArdentController {

	public function __construct(Client $model)
	{
		$this->model = $model;
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

		$activateUsersModal = Input::get('activateUsersModal');
		$organizations = Organization::lists('Name', 'id');

		$listAddresses = array();
/*		$listAddresses = DB::table('users')
				      		->select('users.id as id',
				      				 'users.username as username',
				      				 'users.id_employee as id_employee',
				      				 DB::raw('null AS startDate'),
				      				 DB::raw('null AS endDate'),
				      				 DB::raw('null AS checked'))
				      		->where('id_organization', '=', $model->id_organization)      		
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
				      				 'usersRoles.startDate as startDate',
				      				 'usersRoles.endDate as endDate',
				      				 'usersRoles.id_role as checked')
				      		->leftjoin('usersRoles','users.id', '=', 'usersRoles.id_user')
				      		->where('id_organization', '=', $model->id_organization)      		
				      		->where('id_role', '=', $id)
				      		->union($listUsers1)
				      		->get();
		*/
        return View::make($modelName. '.edit', compact('model', 'modelName', 'tableName', 'organizations', 'listAddresses', 'activateUsersModal'));
	}
}
<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	protected $table = 'users';
	//protected $softDelete = true;
	//public $autoPurgeRedundantAttributes = true;

	protected $guarded = array('id', 'password_confirmation');

	public $fieldName = 'username';
	public $filters = array(
		'id_organization'				=> 'organizations',
	);
	public $filtersWhere = array(
		'id_organization'				=> null,
	);
	public $filtersTemp = array(
		'id_organization'				=> 'organizations',
	);
	public $wheres = array(
		'id_organization'				=> 'organizations',
	);
	public $orderBy = array(
		'username'							=> 'ASC',
	);

	public $arraySearchFields = array('username', 'alternativeId', 'isActive');

	public static $rules = array(
		'username' => 'required',
		'email' => 'required | Between:3,64 | email',
		'password' => 'required | AlphaNum | Between:6,16 | Confirmed',
		'password_confirmation'=> 'Required | AlphaNum | Between:6,16',
		'id_recoveryQuestion' => 'required',
		'answer' => 'required'
		);

	public static $rulesAdditional1 = array(
		'username' => 'unique_with:users, id_organization'
		);

	public static $rulesAdditional2 = array(
		'email' => 'unique_with:users, id_organization'
		);

	public static $rulesForLogin = array(
		'username' => 'required',
		'password' => 'required | AlphaNum | Between:6,16'
		);

	public static $rulesForEdit = array(
		'answer' => 'required'
		);

	public static $rulesForChangePassword = array(
		'password' => 'required | AlphaNum | Between:6,16 | Confirmed',
		'password_confirmation'=> 'Required | AlphaNum | Between:6,16',
		);

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
       	self::observe(new ModelObserver);
    }

    public function organization()
    {
    	return $this->belongsTo('Organization', 'id_organization', 'id');

    }

    public function employee()
    {
    	return $this->belongsTo('Employee', 'id_employee', 'id');

    }

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	public function getRememberToken()
	{
		return $this->attributes['remember_token'];
	}

	public function setRememberToken($value)
	{
		$this->attributes['remember_token'] = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function loadParameters()
	{
		$id_user = Auth::user()->id;
		$id_organization = Session::get('id_organization');

		$arrayAccess = array('System', 'Organization', 'User');

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
			if ($record->value == null || $record->value == "")
				Session::put('_'. $record->name, $record->defaultValue);
			else
				Session::put('_'. $record->name, $record->value);
		}

		// Load the language
		App::setLocale(Session::get('_language'));

		// Default values required to run the app
		if (!Session::has('_numRowsPagination'))
			Session::put('_numRowsPagination', 10);

		// Check if it is necessary to use Parent data
		if (Session::get('_inheritParentData') == 'Yes')
		{
			$id_organizationData = Organization::where('id', '=', $id_organization)->get()->lists('id_parent');
			if (isset($id_organizationData[0]))
				$id_organizationData = $id_organizationData[0];
			else 
				$id_organizationData = $id_organization;
		}
		else
			$id_organizationData = $id_organization;	
		Session::put('id_organizationData', $id_organizationData);

		// Load Mysql version	
		$version = DB::table('users')->select(DB::raw('version() as version'))->first();

		Session::put('__mysqlVersion', floatval($version->version));
	}

	public function loadMenu()
	{
		$id_user = Auth::user()->id;
		$id_organization = Session::get('id_organization');
		$menuDefault = Session::get('_menuDefault');
		$totalAccessAdmin = Session::get('_totalAccessAdmin');
		$menuOptions = array();

		$dateTime = new \DateTime;
		$dateTime = $dateTime->format('Y-m-d H:i:s');

		// If totalAccessAdmin is Yes, and it the main Admin user, give access to every option in the menu
		if ($totalAccessAdmin == 'Yes' && Auth::user()->id == 1)
		{
			$menuItems1 = DB::table('menuItems')
									->select('menuItems.name',
											 'menuItems.level',
											 DB::raw('(CASE WHEN options.link is null THEN "#" ELSE options.link END) as link'),
										     'menuItems.position',
										     DB::raw('1 as authInsert'),
										     DB::raw('1 as authUpdate'),
										     DB::raw('1 as authDelete'),
										     DB::raw('1 as authExecute'))
									->leftjoin('options', 'options.id', '=', 'menuItems.id_option')
									->where('menuItems.id_organization', '=', 1)
									->where('options.isPublished', '=', 'Yes')
									->where(function($query) use ($dateTime)
									{
										$query->where('options.startDate', '<', $dateTime)
											->orWhereNull('options.startDate');
									})
									->where(function($query) use ($dateTime)
									{
										$query->where('options.endDate', '>', $dateTime)
											->orWhereNull('options.endDate');
									})
									->get();

			$menuItems2 = DB::table('menuItems')
									->select('menuItems.name',
											 'menuItems.level',
										     DB::raw('"#" as link'),
										     'menuItems.position',
										     DB::raw('0 as authInsert'),
										     DB::raw('0 as authUpdate'),
										     DB::raw('0 as authDelete'),
										     DB::raw('0 as authExecute'))
									->whereNull('menuItems.id_option')
									->where('menuItems.id_organization', '=', 1)
									->get();

			foreach($menuItems1 as $record)
			{
				$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																				'link' => $record->link,
																				'level' => $record->level,
																				'authInsert' => $record->authInsert,
																				'authUpdate' => $record->authUpdate,
																				'authDelete' => $record->authDelete,
																				'authExecute' => $record->authExecute));
			}
			foreach($menuItems2 as $record)
			{
				if (array_key_exists($record->position, $menuOptions))
					$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																					'link' => $record->link,
																					'level' => $record->level,
																					'authInsert' => max($menuOptions[$record->position]['authInsert'], $record->authInsert),
																					'authUpdate' => max($menuOptions[$record->position]['authUpdate'], $record->authUpdate),
																					'authDelete' => max($menuOptions[$record->position]['authDelete'], $record->authDelete),
																					'authExecute' => max($menuOptions[$record->position]['authExecute'], $record->authExecute)));
				else
				{
					$value = array_first($menuOptions, function($key, $value) use ($record)
					{
						return substr(strval($key),0,1) == substr(strval($record->position),0,1);
					});
					if ($value)
						$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																						'link' => $record->link,
																						'level' => $record->level,
																						'authInsert' => $record->authInsert,
																						'authUpdate' => $record->authUpdate,
																						'authDelete' => $record->authDelete,
																						'authExecute' => $record->authExecute));
				}
			}
			ksort($menuOptions);

		}
		elseif ($menuDefault == 'Yes')
		{
			// Looks for access by Roles
			$menuItems1 = DB::table('roles')
									->select('menuItems.name',
										     'options.link',
										     'menuItems.position',
										     DB::raw('MAX(menuItems.level) as level'),
										     DB::raw('MAX(rolesOptions.insert) as authInsert'),
										     DB::raw('MAX(rolesOptions.update) as authUpdate'),
										     DB::raw('MAX(rolesOptions.delete) as authDelete'),
										     DB::raw('MAX(rolesOptions.execute) as authExecute'))
									->join('usersRoles', 'roles.id', '=', 'usersRoles.id_role')
									->join('rolesOptions', 'roles.id', '=', 'rolesOptions.id_role')
									->join('menuItems', 'rolesOptions.id_option', '=', 'menuItems.id_option')
									->join('options', 'options.id', '=', 'rolesOptions.id_option')
									->where(function($query) use ($dateTime)
									{
										$query->where('usersRoles.startDate', '<', $dateTime)
											->orWhereNull('usersRoles.startDate');
									})
									->where(function($query) use ($dateTime)
									{
										$query->where('usersRoles.endDate', '>', $dateTime)
											->orWhereNull('usersRoles.endDate');
									})									
									->where(function($query) use ($dateTime)
									{
										$query->where('options.startDate', '<', $dateTime)
											->orWhereNull('options.startDate');
									})
									->where(function($query) use ($dateTime)
									{
										$query->where('options.endDate', '>', $dateTime)
											->orWhereNull('options.endDate');
									})
									->where('usersRoles.id_user', '=', $id_user)
									->where('menuItems.id_organization', '=', 1)
									->where('options.isPublished', '=', 'Yes')
									->where('rolesOptions.execute', '=', 1)
									->groupBy('menuItems.id')
									->groupBy('menuItems.name')
									->groupBy('options.link')
									->groupBy('menuItems.position')
									->get();

			// Looks for access by Groups
			$menuItems2 = DB::table('roles')
									->select('menuItems.name',
										     'options.link',
										     'menuItems.position',
										     DB::raw('MAX(menuItems.level) as level'),
										     DB::raw('MAX(rolesOptions.insert) as authInsert'),
										     DB::raw('MAX(rolesOptions.update) as authUpdate'),
										     DB::raw('MAX(rolesOptions.delete) as authDelete'),
										     DB::raw('MAX(rolesOptions.execute) as authExecute'))
									->join('rolesGroups', 'roles.id', '=', 'rolesGroups.id_role')
									->join('usersGroups', 'rolesGroups.id_group', '=', 'usersGroups.id_group')
									->join('rolesOptions', 'roles.id', '=', 'rolesOptions.id_role')
									->join('menuItems', 'rolesOptions.id_option', '=', 'menuItems.id_option')
									->join('options', 'options.id', '=', 'rolesOptions.id_option')
									->where(function($query) use ($dateTime)
									{
										$query->where('options.startDate', '<', $dateTime)
											->orWhereNull('options.startDate');
									})
									->where(function($query) use ($dateTime)
									{
										$query->where('options.endDate', '>', $dateTime)
											->orWhereNull('options.endDate');
									})
									->where('usersGroups.id_user', '=', $id_user)
									->where('menuItems.id_organization', '=', 1)
									->where('options.isPublished', '=', 'Yes')
									->where('rolesOptions.execute', '=', 1)
									->groupBy('menuItems.id')
									->groupBy('menuItems.name')
									->groupBy('options.link')
									->groupBy('menuItems.position')
									->get();

			$menuItems3 = DB::table('menuItems')
									->select('menuItems.name',
										     DB::raw('"#" as link'),
										     'menuItems.position',
										     'menuItems.level',
										     DB::raw('0 as authInsert'),
										     DB::raw('0 as authUpdate'),
										     DB::raw('0 as authDelete'),
										     DB::raw('0 as authExecute'))
									->whereNull('menuItems.id_option')
									->where('menuItems.id_organization', '=', 1)
									->get();

			foreach($menuItems1 as $record)
			{
				$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																				'link' => $record->link,
																				'level' => $record->level,
																				'authInsert' => $record->authInsert,
																				'authUpdate' => $record->authUpdate,
																				'authDelete' => $record->authDelete,
																				'authExecute' => $record->authExecute));
			}
			foreach($menuItems2 as $record)
			{
				if (array_key_exists($record->position, $menuOptions))
					$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																					'link' => $record->link,
																					'level' => $record->level,
																					'authInsert' => max($menuOptions[$record->position]['authInsert'], $record->authInsert),
																					'authUpdate' => max($menuOptions[$record->position]['authUpdate'], $record->authUpdate),
																					'authDelete' => max($menuOptions[$record->position]['authDelete'], $record->authDelete),
																					'authExecute' => max($menuOptions[$record->position]['authExecute'], $record->authExecute)));
				else
					$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																					'link' => $record->link,
																					'level' => $record->level,
																					'authInsert' => $record->authInsert,
																					'authUpdate' => $record->authUpdate,
																					'authDelete' => $record->authDelete,
																					'authExecute' => $record->authExecute));
			}
			foreach($menuItems3 as $record)
			{
				if (array_key_exists($record->position, $menuOptions))
					$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																					'link' => $record->link,
																					'level' => $record->level,
																					'authInsert' => max($menuOptions[$record->position]['authInsert'], $record->authInsert),
																					'authUpdate' => max($menuOptions[$record->position]['authUpdate'], $record->authUpdate),
																					'authDelete' => max($menuOptions[$record->position]['authDelete'], $record->authDelete),
																					'authExecute' => max($menuOptions[$record->position]['authExecute'], $record->authExecute)));
				else
				{
					// Check if there are subMenu option
					$value = array_first($menuOptions, function($key, $value) use ($record)
					{
						return substr(strval($key),0,1) == substr(strval($record->position),0,1);
					});
					if ($value)
						$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																						'link' => $record->link,
																						'level' => $record->level,
																						'authInsert' => $record->authInsert,
																						'authUpdate' => $record->authUpdate,
																						'authDelete' => $record->authDelete,
																						'authExecute' => $record->authExecute));
				}
			}
			ksort($menuOptions);
		}
		else
		{
			// Looks for access by Roles
			$menuItems1 = DB::table('roles')
									->select('menuItems.name',
										     'options.link',
										     'menuItems.position',
										     DB::raw('MAX(menuItems.level) as level'),
										     DB::raw('MAX(rolesOptions.insert) as authInsert'),
										     DB::raw('MAX(rolesOptions.update) as authUpdate'),
										     DB::raw('MAX(rolesOptions.delete) as authDelete'),
										     DB::raw('MAX(rolesOptions.execute) as authExecute'))
									->join('usersRoles', 'roles.id', '=', 'usersRoles.id_role')
									->join('rolesOptions', 'roles.id', '=', 'rolesOptions.id_role')
									->join('menuItems', 'rolesOptions.id_option', '=', 'menuItems.id_option')
									->join('options', 'options.id', '=', 'rolesOptions.id_option')
									->where(function($query) use ($dateTime)
									{
										$query->where('usersRoles.startDate', '<', $dateTime)
											->orWhereNull('usersRoles.startDate');
									})
									->where(function($query) use ($dateTime)
									{
										$query->where('usersRoles.endDate', '>', $dateTime)
											->orWhereNull('usersRoles.endDate');
									})									
									->where(function($query) use ($dateTime)
									{
										$query->where('options.startDate', '<', $dateTime)
											->orWhereNull('options.startDate');
									})
									->where(function($query) use ($dateTime)
									{
										$query->where('options.endDate', '>', $dateTime)
											->orWhereNull('options.endDate');
									})
									->where('usersRoles.id_user', '=', $id_user)
									->where('menuItems.id_organization', '=', $id_organization)
									->where('options.isPublished', '=', 'Yes')
									->where('rolesOptions.execute', '=', 1)
									->groupBy('menuItems.id')
									->groupBy('menuItems.name')
									->groupBy('options.link')
									->groupBy('menuItems.position')
									->get();


			// Looks for access by Groups
			$menuItems2 = DB::table('roles')
									->select('menuItems.name',
										     'options.link',
										     'menuItems.position',
										     DB::raw('MAX(menuItems.level) as level'),
										     DB::raw('MAX(rolesOptions.insert) as authInsert'),
										     DB::raw('MAX(rolesOptions.update) as authUpdate'),
										     DB::raw('MAX(rolesOptions.delete) as authDelete'),
										     DB::raw('MAX(rolesOptions.execute) as authExecute'))
									->join('rolesGroups', 'roles.id', '=', 'rolesGroups.id_role')
									->join('usersGroups', 'rolesGroups.id_group', '=', 'usersGroups.id_group')
									->join('rolesOptions', 'roles.id', '=', 'rolesOptions.id_role')
									->join('menuItems', 'rolesOptions.id_option', '=', 'menuItems.id_option')
									->join('options', 'options.id', '=', 'rolesOptions.id_option')
									->where(function($query) use ($dateTime)
									{
										$query->where('options.startDate', '<', $dateTime)
											->orWhereNull('options.startDate');
									})
									->where(function($query) use ($dateTime)
									{
										$query->where('options.endDate', '>', $dateTime)
											->orWhereNull('options.endDate');
									})
									->where('usersGroups.id_user', '=', $id_user)
									->where('menuItems.id_organization', '=', $id_organization)
									->where('options.isPublished', '=', 'Yes')
									->where('rolesOptions.execute', '=', 1)
									->groupBy('menuItems.id')
									->groupBy('menuItems.name')
									->groupBy('options.link')
									->groupBy('menuItems.position')
									->get();

			$menuItems3 = DB::table('menuItems')
									->select('menuItems.name',
										     DB::raw('"#" as link'),
										     'menuItems.position',
										     DB::raw('MAX(menuItems.level) as level'),
										     DB::raw('0 as authInsert'),
										     DB::raw('0 as authUpdate'),
										     DB::raw('0 as authDelete'),
										     DB::raw('0 as authExecute'))
									->whereNull('menuItems.id_option')
									->where('menuItems.id_organization', '=', $id_organization)
									->get();

			foreach($menuItems1 as $record)
			{
				$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																				'link' => $record->link,
																				'level' => $record->level,
																				'authInsert' => $record->authInsert,
																				'authUpdate' => $record->authUpdate,
																				'authDelete' => $record->authDelete,
																				'authExecute' => $record->authExecute));
			}
			foreach($menuItems2 as $record)
			{
				if (array_key_exists($record->position, $menuOptions))
					$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																					'link' => $record->link,
																					'level' => $record->level,
																					'authInsert' => max($menuOptions[$record->position]['authInsert'], $record->authInsert),
																					'authUpdate' => max($menuOptions[$record->position]['authUpdate'], $record->authUpdate),
																					'authDelete' => max($menuOptions[$record->position]['authDelete'], $record->authDelete),
																					'authExecute' => max($menuOptions[$record->position]['authExecute'], $record->authExecute)));
				else
					$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																					'link' => $record->link,
																					'level' => $record->level,
																					'authInsert' => $record->authInsert,
																					'authUpdate' => $record->authUpdate,
																					'authDelete' => $record->authDelete,
																					'authExecute' => $record->authExecute));
			}
			foreach($menuItems3 as $record)
			{
				if (array_key_exists($record->position, $menuOptions))
					$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																					'link' => $record->link,
																					'level' => $record->level,
																					'authInsert' => max($menuOptions[$record->position]['authInsert'], $record->authInsert),
																					'authUpdate' => max($menuOptions[$record->position]['authUpdate'], $record->authUpdate),
																					'authDelete' => max($menuOptions[$record->position]['authDelete'], $record->authDelete),
																					'authExecute' => max($menuOptions[$record->position]['authExecute'], $record->authExecute)));
				else
				{
					$value = array_first($menuOptions, function($key, $value) use ($record)
					{
						return substr(strval($key),0,1) == substr(strval($record->position),0,1);
					});
					if ($value)
						$menuOptions = array_add($menuOptions, $record->position, array('name' => $record->name,
																						'link' => $record->link,
																						'level' => $record->level,
																						'authInsert' => $record->authInsert,
																						'authUpdate' => $record->authUpdate,
																						'authDelete' => $record->authDelete,
																						'authExecute' => $record->authExecute));
				}
			}
			ksort($menuOptions);
		}		
		$lastKey = 0;
		foreach($menuOptions as $key => $option)
		{
			if ($lastKey !=0 && $menuOptions[$key]['level'] > $menuOptions[$lastKey]['level'])
				$menuOptions[$lastKey]['dropdown'] = 'Yes';
			else
			{
				if ($lastKey != 0)
					$menuOptions[$lastKey]['dropdown'] = 'No';
			}

			if ($lastKey !=0 && $menuOptions[$key]['level'] < $menuOptions[$lastKey]['level'])
				$menuOptions[$lastKey]['closeDropdown'] = 'Yes';
			else
			{
				if ($lastKey != 0)
					$menuOptions[$lastKey]['closeDropdown'] = 'No';
			}

			$lastKey = $key;
		}
		if (count($menuOptions))
		{
			$menuOptions[$lastKey]['dropdown'] = 'No';
			$menuOptions[$lastKey]['closeDropdown'] = 'No';
		}
		Session::put('menuOptions', $menuOptions);
	}

	public function getDatabases()
	{
		$databases = array();
		if (Auth::user()->id == 1)
		{
			$databases = Database::lists('id');
		}
		else
		{
			$organizations = Organization::where('id', '=', Session::get('id_organization'))
							->get();
			foreach($organizations as $key => $value)
			{
				if ($value->id_database)
				{
					$databases = array($value->id_database);
				}
				else
				{
					do
					{
						if ($value->id_parent)
						{
							$parent = Organization::where('id', '=', $value->id_parent)
									->first();
							$databases = Database::where('id', '=', $parent->id_database)
									->lists('id');
							//var_dump($databases);
							$value = $parent;
						}
						else
							break;
					} while (count($databases) == 0);
				}
			}
		}
		//dd($databases);
		return $databases;
	}

	public function getListDatabases()
	{
		$databases = array();
		if (Auth::user()->id == 1)
		{
			$databases = Database::lists('name', 'id');
		}
		else
		{
			$organizations = Organization::where('id', '=', Session::get('id_organization'))
							->get();
			foreach($organizations as $key => $value)
			{
				if ($value->id_database)
				{
					$databases = array($value->id_database => $value->database->name);
				}
				else
				{
					do
					{
						if ($value->id_parent)
						{
							$parent = Organization::where('id', '=', $value->id_parent)
									->first();
							$databases = Database::where('id', '=', $parent->id_database)
									->lists('name', 'id');
							$value = $parent;
						}
						else
							break;
					} while (count($databases) == 0);
				}
			}
		}
		return $databases;
	}
}

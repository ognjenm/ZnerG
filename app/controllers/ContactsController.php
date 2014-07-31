<?php

class ContactsController extends ArdentController {

	public function __construct(Contact $model)
	{
		$this->model = $model;
	}

	public function index()
	{
		// get the wheres value for databases
		$this->model->wheres['id_database'] = Auth::user()->getDatabases();

		return parent::index();

	}

	public function getSearch()
	{
		// get the wheres value for databases
		$this->model->wheres['id_database'] = Auth::user()->getDatabases();

		return parent::getSearch();

	}

	public function createDetail()
	{
		$databases = Auth::user()->getListDatabases();
        return parent::createDetail()->with('databases', $databases);
	}

	public function store()
	{
		$modelName = Session::get('modelName');	

		if ($this->model->save())
		{
			// If it has been send an id_address, insert that as a location
			if (Session::has('instanceData'))
			{
				$instanceData = Session::get('instanceData');
				if (isset($instanceData['id_address']))
				{
					$id_address = $instanceData['id_address'];
					$location = new Location;
					$location->id_address = $id_address;
					$location->id_business = $this->model->id;
					$location->id_statusLocation = 1;
					$location->save();
				}
			}
			Session::put('id', $this->model->id);
			return Redirect::to($modelName . '/editDetail')->with('nestedCall', Session::get('nestedCall'))
															->with('nestedRoute', Session::get('nestedRoutePath'));
		}
		else
			return Redirect::route($modelName. '.create')
				->withInput()
				->withErrors($this->model->errors());
	}
	
	public function edit($id)
	{
		if (Session::get('id_tab'))
			$id_tab = Session::get('id_tab');
		elseif (Input::get('id_tab'))
			$id_tab = Input::get('id_tab');
		else
			$id_tab = 1;
		Session::put('id_tab', $id_tab);	

		Session::forget('activateLocationsModal');
		return parent::edit($id);
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function editDetail()
	{	
		$activateEditLocationsModal = Input::get('activateEditLocationsModal');
		$id_location = Session::get('id_location');

		if ($id_location)
			$location = DB::table('locations')->join('addresses', 'locations.id_address', '=', 'addresses.id')
									            ->select('addresses.id_city', 'addresses.id_database', 'addresses.id_statusAddress', 'addresses.id_typesAddress', 'addresses.addressLine1', 'addresses.addressLine2', 'addresses.suite', 'addresses.zipcode', 'addresses.reference', 'locations.phone', 'locations.phoneAdditional', 'locations.fax', 'locations.id_statusLocation', 'locations.isHeadquarter', 'locations.isShipping', 'locations.isBilling', 'locations.isActive')
												->where('locations.id', '=', $id_location)->first();
		else
			$location = null;

		if (Session::has('id_tab'))
			$id_tab = Session::get('id_tab');
		else
		{
			$id_tab = 1;
			Session::put('id_tab', $id_tab);	
		}

		$databases = Auth::user()->getListDatabases();
		$activateLocationsModal = Input::get('activateLocationsModal');

		if (Session::has('id'))
			$id = Session::get('id');
		else
			$id = Session::get('id_ardent');
		Session::put('id_ardent', $id);

		$this->model = $this->model->find($id);
		$locations =  Location::where('id_business', '=', $id)
								->get();

		$id_organization = Session::get('id_organization');

		$cities = City::where('id_state', '=', Session::get('_stateDefault'))
		 					->lists('name', 'id');
		$statusAddresses = StatusAddress::where('id_organization', '=', $id_organization)
										->lists('name', 'id');
		$typesAddresses = TypesAddress::where('id_organization', '=', $id_organization)
		 								->lists('name', 'id');
		$statusLocations = StatusLocation::where('id_organization', '=', $id_organization)
										->lists('name', 'id');

        return parent::editDetail()->with('id', $id)
        						->with('cities', $cities)
        						->with('databases', $databases)
        						->with('locations', $locations)
        						->with('statusAddresses', $statusAddresses)
        						->with('typesAddresses', $typesAddresses)
        						->with('statusLocations', $statusLocations)
        						->with('activateLocationsModal', $activateLocationsModal)
        						->with('activateEditLocationsModal', $activateEditLocationsModal)
        						->with('location', $location)
  						        ->with('id_tab', $id_tab);
	}

	public function cancelTabModal($id_tab)
	{
		$modelName = Session::get('modelName');
		Session::put('id_tab', $id_tab);	
		return Redirect::to($modelName . '/editDetail')->with('nestedCall', Session::get('nestedCall'))
														->with('nestedRoute', Session::get('nestedRoutePath'))
														->withInput();
	}

	public function editLocation()
	{
		$modelName = Session::get('modelName');
		$id = Input::get('id');	
		Session::put('id_tab', Input::get('id_tab'));	
		Input::merge(array('activateEditLocationsModal' => 'Yes'));

		return Redirect::to($modelName . '/editDetail')->with('nestedCall', Session::get('nestedCall'))
														->with('nestedRoute', Session::get('nestedRoutePath'))
														->with('id_location', $id)
														->withInput();
	}

	public function storeLocation()
	{
		$modelName = Session::get('modelName');
		$id = Input::get('id');	
		Session::put('id_tab', Input::get('id_tab'));	

		$location = new Location;
		$location = $location->find($id);
		$location->phone = Input::get('phone');
		$location->phoneAdditional = Input::get('phoneAdditional');
		$location->fax = Input::get('fax');
		$location->id_statusLocation = Input::get('id_statusLocation');
		$location->isHeadquarter = Input::get('isHeadquarter');
		$location->isShipping = Input::get('isShipping');
		$location->isBilling = Input::get('isBilling');
		$location->isActive = Input::get('isActive');
		$result = $location->save();
		if ($result)
		{
			$address = new Address;
			$address = $address->find($location->id_address);
			$address->id_city = Input::get('id_city');
			$address->id_database = Input::get('id_database');
			$address->id_statusAddress = Input::get('id_statusAddress');
			$address->id_typesAddress = Input::get('id_typesAddress');
			$address->addressLine1 = Input::get('addressLine1');
			$address->addressLine2 = Input::get('addressLine2');
			$address->suite = Input::get('suite');
			$address->zipcode = Input::get('zipcode');
			$address->reference = Input::get('reference');
			$result = $address->save();
			if ($result)
			{
				Input::merge(array('activateEditLocationsModal' => 'No'));

				return Redirect::to($modelName . '/editDetail')->with('nestedCall', Session::get('nestedCall'))
																->with('nestedRoute', Session::get('nestedRoutePath'))
																->withInput();
			}
			else
			{
				Input::merge(array('activateEditLocationsModal' => 'Yes'));
				return Redirect::to($modelName. '/editDetail')
									->with('nestedCall', 'No')
									->with('nestedRoute', $modelName . '.index')
									->withInput()
									->withErrors($location->errors())
									->with('errorModal', 'Yes');

			}
		}
		else
		{
			Input::merge(array('activateEditLocationsModal' => 'Yes'));
			return Redirect::to($modelName. '/editDetail')
								->with('nestedCall', 'No')
								->with('nestedRoute', $modelName . '.index')
								->withInput()
								->withErrors($location->errors())
								->with('errorModal', 'Yes');

		}
	}

	public function deleteLocation()
	{
		$modelName = Session::get('modelName');
		$id = Input::get('id');	
		Session::put('id_tab', Input::get('id_tab'));	
		$location = new Location;

		$location = $location->find($id);
		$location->destroy($id);

		return Redirect::to($modelName . '/editDetail')->with('nestedCall', Session::get('nestedCall'))
														->with('nestedRoute', Session::get('nestedRoutePath'));
	}

	public function assignLocations()
	{
		$modelName = Session::get('modelName');
		Session::put('id_tab', Input::get('id_tab'));	
		$id = Input::get('id_business');
		$id_location = Input::get('id_location');
		if ($id_location)
		{
			// We update address information
			$address = Address::find($id_location);
			var_dump('Updating');

		}
		else
		{
			// We insert address information
			var_dump('Inserting');
			$address = new Address;
			$address->id_city = Input::get('id_city');
			$address->id_database = Input::get('id_database');
			$address->id_statusAddress = Input::get('id_statusAddress');
			$address->id_typesAddress = Input::get('id_typesAddress');
			$address->addressLine1 = Input::get('addressLine1');
			$address->addressLine2 = Input::get('addressLine2');
			$address->suite = Input::get('suite');
			$address->zipcode = Input::get('zipcode');
			$address->latitude = Input::get('latitude');
			$address->longitude = Input::get('longitude');
			$address->reference = Input::get('reference');

			$result = $address->save();
			if ($result)
			{
				// We insert location information
				var_dump('Address Inserted');
				$location = new Location;
				$location->id_business = $id;			
				$location->id_address = $address->id;
				$location->id_statusLocation = Input::get('id_statusLocation');	
				$location->phone = Input::get('phone');	
				$location->phoneAdditional = Input::get('phoneAdditional');	
				$location->fax = Input::get('fax');	
				$location->isHeadquarter = Input::get('isHeadquarter');	
				$location->isShipping = Input::get('isShipping');	
				$location->isBilling = Input::get('isBilling');	
				$location->isActive = Input::get('isActive');
				$result = $location->save();
				if ($result)
				{
					return Redirect::to($modelName . '/editDetail')->with('nestedCall', Session::get('nestedCall'))
																	->with('nestedRoute', Session::get('nestedRoutePath'));
				}
				else
				{
					Input::merge(array('activateLocationsModal' => 'Yes'));
					return Redirect::to($modelName. '/editDetail')
										->with('nestedCall', 'No')
										->with('nestedRoute', $modelName . '.index')
										->withInput()
										->withErrors($location->errors())
										->with('errorModal', 'Yes');
	//									->with('activateLocationsModal', 'Yes');
				}
			}
			else
			{
				Input::merge(array('activateLocationsModal' => 'Yes'));
				return Redirect::to($modelName. '/editDetail')
									->with('nestedCall', 'No')
									->with('nestedRoute', $modelName . '.index')
									->withInput()
									->withErrors($address->errors())
									->with('errorModal', 'Yes');
	//								->with('activateLocationsModal', 'Yes');
			}
		}
	}
}




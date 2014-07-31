<?php

class BusinessesController extends ArdentController {

	public function __construct(Business $model)
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

		$id_campaign =  Session::get('id_campaign');
		$typesBusinesses = TypesBusiness::where('isActive', '=', 'Yes')
										->where('id_campaign', '=', $id_campaign)
										->lists('name', 'id');
		//id_activitiesProcess
        return parent::createDetail()->with('databases', $databases)
        							->with('typesBusinesses', $typesBusinesses);
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
		if (Input::get('id_tab'))
			$id_tab = Input::get('id_tab');
		elseif (Session::has('id_tab'))
			$id_tab = Session::get('id_tab');
		else
			$id_tab = 1;
		Session::put('id_tab', $id_tab);	

		Session::forget('activateLocationsModal');
		Session::forget('activateContactsBusinessesModal');
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
		if (Input::get('id_tab'))
			$id_tab = Input::get('id_tab');
		elseif (Session::has('id_tab'))
			$id_tab = Session::get('id_tab');
		else
			$id_tab = 1;
		Session::put('id_tab', $id_tab);	

		$activateEditLocationsModal = Input::get('activateEditLocationsModal');
		$id_location = Session::get('id_location');

		if ($id_location)
			$location = DB::table('locations')->join('addresses', 'locations.id_address', '=', 'addresses.id')
									            ->select('addresses.id_city', 'addresses.id_database', 'addresses.id_statusAddress', 'addresses.id_typesAddress', 'addresses.addressLine1', 'addresses.addressLine2', 'addresses.suite', 'addresses.zipcode', 'addresses.reference', 'locations.phone', 'locations.phoneAdditional', 'locations.fax', 'locations.id_statusLocation', 'locations.isHeadquarter', 'locations.isShipping', 'locations.isBilling', 'locations.isActive')
												->where('locations.id', '=', $id_location)->first();
		else
			$location = null;

		$activateEditContactsBusinessesModal = Input::get('activateEditContactsBusinessesModal');
		$id_contact = Session::get('id_contact');

		if ($id_contact)
			$contactsBusiness = DB::table('contactsBusinesses')->join('contacts', 'contactsBusinesses.id_contact', '=', 'contacts.id')
									            ->select('contacts.id_database', 'contacts.firstName', 'contacts.lastName', 'contacts.phone', 'contacts.phoneAdditional', 'contacts.email', 'contacts.emailAdditional', 'contacts.notes',
									             'contactsBusinesses.position', 'contactsBusinesses.dayMonday', 'contactsBusinesses.dayTuesday', 'contactsBusinesses.dayWednesday', 'contactsBusinesses.dayThursday', 'contactsBusinesses.dayFriday', 'contactsBusinesses.daySaturday', 'contactsBusinesses.start', 'contactsBusinesses.end', 'contactsBusinesses.isActive', 'contactsBusinesses.scheduleNotes')
												->where('contactsBusinesses.id', '=', $id_contact)->first();
		else
			$contactsBusiness = null;

		$databases = Auth::user()->getListDatabases();
		$activateLocationsModal = Input::get('activateLocationsModal');
		$activateContactsBusinessesModal = Input::get('activateContactsBusinessesModal');

		if (Session::has('id'))
			$id = Session::get('id');
		else
			$id = Session::get('id_ardent');
		Session::put('id_ardent', $id);

		$this->model = $this->model->find($id);
		$locations =  Location::where('id_business', '=', $id)
								->get();

		$contactsBusinesses =  ContactsBusiness::where('id_business', '=', $id)
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
		$id_campaign =  Session::get('id_campaign');
		$typesBusinesses = TypesBusiness::where('isActive', '=', 'Yes')
										->where('id_campaign', '=', $id_campaign)
										->lists('name', 'id');

        return parent::editDetail()->with('id', $id)
        						->with('cities', $cities)
        						->with('databases', $databases)
        						->with('locations', $locations)
        						->with('contactsBusinesses', $contactsBusinesses)
        						->with('statusAddresses', $statusAddresses)
        						->with('typesAddresses', $typesAddresses)
        						->with('typesBusinesses', $typesBusinesses)
        						->with('statusLocations', $statusLocations)
        						->with('activateLocationsModal', $activateLocationsModal)
        						->with('activateEditLocationsModal', $activateEditLocationsModal)
        						->with('activateContactsBusinessesModal', $activateContactsBusinessesModal)
        						->with('activateEditContactsBusinessesModal', $activateEditContactsBusinessesModal)
        						->with('location', $location)
        						->with('contactsBusiness', $contactsBusiness)
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
														->with('id_tab', 2)
														->withInput();
	}

	public function editContactsBusiness()
	{
		$modelName = Session::get('modelName');
		$id = Input::get('id');	
		Session::put('id_tab', Input::get('id_tab'));	
		Input::merge(array('activateEditContactsBusinessesModal' => 'Yes'));
		return Redirect::to($modelName . '/editDetail')->with('nestedCall', Session::get('nestedCall'))
														->with('nestedRoute', Session::get('nestedRoutePath'))
														->with('id_contact', $id)
														->with('id_tab', 3)
														->withInput();
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
														->with('nestedRoute', Session::get('nestedRoutePath'))
														->with('id_tab', 2);
	}

	public function deleteContactsBusiness()
	{
		$modelName = Session::get('modelName');
		$id = Input::get('id');	
		Session::put('id_tab', Input::get('id_tab'));	
		$contactsBusiness = new ContactsBusiness;
		$contact = new Contact;

		$contactsBusiness = $contactsBusiness->find($id);
		$id_contact = $contactsBusiness->id_contact;

		$contactsBusiness->destroy($id);
		$contact->destroy($id_contact);

		return Redirect::to($modelName . '/editDetail')->with('nestedCall', Session::get('nestedCall'))
														->with('nestedRoute', Session::get('nestedRoutePath'))
														->with('id_tab', 3);
	}

	public function assignLocation()
	{
		$modelName = Session::get('modelName');
//		Session::put('id_tab', Input::get('id_tab'));	
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
																	->with('nestedRoute', Session::get('nestedRoutePath'))
																	->with('id_tab', 2);
				}
				else
				{
					Input::merge(array('activateLocationsModal' => 'Yes'));
					return Redirect::to($modelName. '/editDetail')
										->with('nestedCall', 'No')
										->with('nestedRoute', $modelName . '.index')
										->with('id_tab', 2)
										->withInput()
										->withErrors($location->errors())
										->with('errorModal', 'Yes');
				}
			}
			else
			{
				Input::merge(array('activateLocationsModal' => 'Yes'));
				return Redirect::to($modelName. '/editDetail')
									->with('nestedCall', 'No')
									->with('nestedRoute', $modelName . '.index')
									->with('id_tab', 2)
									->withInput()
									->withErrors($address->errors())
									->with('errorModal', 'Yes');
			}
		}
	}
	public function assignContact()
	{
		$modelName = Session::get('modelName');
//		Session::put('id_tab', Input::get('id_tab'));	
		$id = Input::get('id_business');
		$id_contact = Input::get('id_contact');
		if ($id_contact)
		{
			dd('Roca');
			// We update address information
			$contact = Contact::find($id_contact);
		}
		else
		{
			// We insert address information
			$contact = new Contact;
			$contact->id_database = Input::get('id_database');
			$contact->firstName = Input::get('firstName');
			$contact->lastName = Input::get('lastName');
			$contact->phone = Input::get('phone');
			$contact->phoneAdditional = Input::get('phoneAdditional');
			$contact->email = Input::get('email');
			$contact->emailAdditional = Input::get('emailAdditional');
			$contact->notes = Input::get('notes');

			$result = $contact->save();
			if ($result)
			{
				// We insert contactBusiness information
				var_dump('Contact Inserted');
				$contactsBusiness = new ContactsBusiness;
				$contactsBusiness->id_business = $id;			
				$contactsBusiness->id_contact = $contact->id;
				$contactsBusiness->position = Input::get('position');	
				$contactsBusiness->dayMonday = Input::get('dayMonday');	
				$contactsBusiness->dayTuesday = Input::get('dayTuesday');	
				$contactsBusiness->dayWednesday = Input::get('dayWednesday');	
				$contactsBusiness->dayThursday = Input::get('dayThursday');	
				$contactsBusiness->dayFriday = Input::get('dayFriday');	
				$contactsBusiness->daySaturday = Input::get('daySaturday');	
				$contactsBusiness->start = Input::get('start');	
				$contactsBusiness->end = Input::get('end');	
				$contactsBusiness->isActive = Input::get('isActive');
				$contactsBusiness->scheduleNotes = Input::get('scheduleNotes');	
				$result = $contactsBusiness->save();
				if ($result)
				{
					return Redirect::to($modelName . '/editDetail')->with('nestedCall', Session::get('nestedCall'))
																	->with('nestedRoute', Session::get('nestedRoutePath'))
																	->with('id_tab', 3);
				}
				else
				{
					Input::merge(array('activateContactsBusinessesModal' => 'Yes'));
					return Redirect::to($modelName. '/editDetail')
										->with('nestedCall', 'No')
										->with('nestedRoute', $modelName . '.index')
										->with('id_tab', 3)
										->withInput()
										->withErrors($contactsBusiness->errors())
										->with('errorModal', 'Yes');
				}
			}
			else
			{
				Input::merge(array('activateContactsBusinessesModal' => 'Yes'));
				return Redirect::to($modelName. '/editDetail')
									->with('nestedCall', 'No')
									->with('nestedRoute', $modelName . '.index')
									->with('id_tab', 3)
									->withInput()
									->withErrors($contact->errors())
									->with('errorModal', 'Yes');
			}
		}
	}

	public function storeLocation()
	{
		$modelName = Session::get('modelName');
		$id = Input::get('id');	
//		Session::put('id_tab', Input::get('id_tab'));	

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
																->with('id_tab', 2)
																->withInput();
			}
			else
			{
				Input::merge(array('activateEditLocationsModal' => 'Yes'));
				return Redirect::to($modelName. '/editDetail')
									->with('nestedCall', 'No')
									->with('nestedRoute', $modelName . '.index')
									->with('id_tab', 2)
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
								->with('id_tab', 2)
								->withInput()
								->withErrors($location->errors())
								->with('errorModal', 'Yes');

		}
	}

	public function storeContact()
	{
		$modelName = Session::get('modelName');
		$id = Input::get('id');	
//		Session::put('id_tab', Input::get('id_tab'));	

		$contactsBusiness = new ContactsBusiness;
		$contactsBusiness = $contactsBusiness->find($id);

		$contact = new Contact;
		$contact = $contact->find($contactsBusiness->id_contact);
		$contact->id_database = Input::get('id_database');
		$contact->firstName = Input::get('firstName');
		$contact->lastName = Input::get('lastName');
		$contact->phone = Input::get('phone');
		$contact->phoneAdditional = Input::get('phoneAdditional');
		$contact->email = Input::get('email');
		$contact->emailAdditional = Input::get('emailAdditional');
		$contact->notes = Input::get('notes');
		//dd($contact);
		$result = $contact->save();
		if ($result)
		{
			$contactsBusiness->position = Input::get('position');	
			$contactsBusiness->dayMonday = Input::get('dayMonday');	
			$contactsBusiness->dayTuesday = Input::get('dayTuesday');	
			$contactsBusiness->dayWednesday = Input::get('dayWednesday');	
			$contactsBusiness->dayThursday = Input::get('dayThursday');	
			$contactsBusiness->dayFriday = Input::get('dayFriday');	
			$contactsBusiness->daySaturday = Input::get('daySaturday');	
			$contactsBusiness->start = Input::get('start');	
			$contactsBusiness->end = Input::get('end');	
			$contactsBusiness->isActive = Input::get('isActive');
			$contactsBusiness->scheduleNotes = Input::get('scheduleNotes');	
			$result = $contactsBusiness->save();
			if ($result)
			{
				Input::merge(array('activateEditContactsBusinessesModal' => 'No'));

				return Redirect::to($modelName . '/editDetail')->with('nestedCall', Session::get('nestedCall'))
																->with('nestedRoute', Session::get('nestedRoutePath'))
																->with('id_tab', 3)
																->withInput();
			}
			else
			{
				Input::merge(array('activateEditContactsBusinessesModal' => 'Yes'));
				return Redirect::to($modelName. '/editDetail')
									->with('nestedCall', 'No')
									->with('nestedRoute', $modelName . '.index')
									->with('id_tab', 3)
									->withInput()
									->withErrors($contactsBusiness->errors())
									->with('errorModal', 'Yes');

			}
		}
		else
		{
			Input::merge(array('activateEditContactsBusinessesModal' => 'Yes'));
			return Redirect::to($modelName. '/editDetail')
								->with('nestedCall', 'No')
								->with('nestedRoute', $modelName . '.index')
								->with('id_tab', 3)
								->withInput()
								->withErrors($contact->errors())
								->with('errorModal', 'Yes');

		}
	}

}




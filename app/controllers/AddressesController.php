<?php

class AddressesController extends ArdentController {

	public function __construct(Address $model)
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
		$id_organization = Session::get('id_organization');

		$lat = Session::get('lat');
		$lon = Session::get('lon');
		try {
 		   $geocode = Geocoder::reverse($lat, $lon);
		} catch (\Exception $e) {
		    // Here we will get "The FreeGeoIpProvider does not support Street addresses." ;)
		    $error = $e->getMessage();
		}	
		$id_country = 1;
		$id_state = null;
		$id_city = null;
		$addressLine1 = null;
		$zipcode = null;
		if ($geocode)
		{
			$country = Country::where('name', '=', $geocode->getCountry())
								->get();
			// If there is only 1 country we continue
			if ($country->count() == 1)
			{
				$country = $country->first();
				$id_country = $country->id;
				$state = State::where('id_country', '=', $id_country)
								->where('name', '=', $geocode->getRegion())
								->get();
				if ($state->count() == 0)
				{
					// We create the state.
					$state = new State();
					$state->name = $geocode->getState();
					$state->id_country = $id_country;
					$state->save();
					$id_state = $state->id;
				}
				elseif ($state->count() == 1)
				{
					$state =  $state->first();
					$id_state = $state->id;
				}
				$city = City::where('id_state', '=', $id_state)
								->where('name', '=', $geocode->getCity())
								->get();
				if ($city->count() == 0)
				{
					// We create the city.
					$city = new City();
					$city->name = $geocode->getCity();
					$city->id_state = $id_state;
					$city->save();
					$id_city = $city->id;
				}
				elseif ($city->count() == 1)
				{
					$city =  $city->first();
					$id_city = $city->id;
				}
				// Now we can show the information complete
				$addressLine1 = $geocode->getStreetNumber() . ' ' . $geocode->getStreetName();
				$zipcode = $geocode->getZipcode();
			}
		}			
		$states = State::where('id_country', '=', $id_country)
						->lists('name', 'id');
		// Load default state
		if (!$id_state)
			$id_state = Session::get('_stateDefault');
		
		$cities = City::where('id_state', '=', $id_state)
							->lists('name', 'id');
		// Load first city in the list
		if (!$id_city)
			$id_city = key($cities);

		$databases = Auth::user()->getListDatabases();
		$statusAddresses = StatusAddress::where('id_organization', '=', $id_organization)
										->lists('name', 'id');
		$typesAddresses = TypesAddress::where('id_organization', '=', $id_organization)
										->lists('name', 'id');

        return parent::createDetail()->with('states', $states)
        						->with('cities', $cities)
        						->with('databases', $databases)
        						->with('statusAddresses', $statusAddresses)
        						->with('typesAddresses', $typesAddresses)
        						->with('id_state', $id_state)
        						->with('id_city', $id_city)
        						->with('addressLine1', $addressLine1)
        						->with('zipcode', $zipcode);

	}

	public function store()
	{
		// First check if it exists
		$addresses = Address::where('addressLine1', '=', Input::get('addressLine1'))
							->where('suite', '=', Input::get('suite'))
							->where('id_city', '=', Input::get('id_city'))
							->where('zipcode', '=', Input::get('zipcode'))
							->get();
		// We found an address with the same information
		if ($addresses->count() > 0)
		{
			$address = $addresses->first();

			// First calculate the lat and lon for the address
			$city = City::where('id', '=', Input::get('id_city'))
					->get()->first();
			$state = State::where('id', '=', Input::get('id_state'))
					->get()->first();
			$addressText = Input::get('addressLine1') . ', ' . $city->name . ', ' . $state->name . ', ' . Input::get('zipcode');
			try {
			    $geocode = Geocoder::geocode($addressText);
			    $input = Input::all();
			    $input['latitude'] = $geocode->getLatitude();
			    $input['longitude'] = $geocode->getLongitude();
			    $input['addressLine2'] = $address->addressLine2;
			    $input['reference'] = $address->reference;
			    $input['id_typesAddress'] =$address->id_typesAddress;
			    $input['id_statusAddress'] = $address->id_statusAddress;

			    Input::merge($input);
			    // Update the hidden fields for latitude and longitude

			} catch (\Exception $e) {
			    // No exception will be thrown here
			    echo $e->getMessage();
			}
			return parent::update($address->id);
		}
		else
		{
			// First calculate the lat and lon for the address
			$city = City::where('id', '=', Input::get('id_city'))
					->get()->first();
			$state = State::where('id', '=', Input::get('id_state'))
					->get()->first();
			$addressText = Input::get('addressLine1') . ', ' . $city->name . ', ' . $state->name . ', ' . Input::get('zipcode');
			try {
			    $geocode = Geocoder::geocode($addressText);
			    $input = Input::all();
			    $input['latitude'] = $geocode->getLatitude();
			    $input['longitude'] = $geocode->getLongitude();
			    $input['zipcode'] = $geocode->getZipcode();
			    Input::merge($input);
			    // Update the hidden fields for latitude and longitude

			} catch (\Exception $e) {
			    // No exception will be thrown here
			    echo $e->getMessage();
			}
			return parent::store();
		}
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function show($id)
	{
		$id_organization = Session::get('id_organization');

		$states = State::lists('name', 'id');
		$cities = City::lists('name', 'id');
		// // Load first city in the list
		// $id_city = key($cities);
		$databases = Auth::user()->getListDatabases();
		$statusAddresses = StatusAddress::where('id_organization', '=', $id_organization)
										->lists('name', 'id');
		$typesAddresses = TypesAddress::where('id_organization', '=', $id_organization)
										->lists('name', 'id');

        return parent::show($id)->with('states', $states)
        						->with('cities', $cities)
        						->with('databases', $databases)
        						->with('statusAddresses', $statusAddresses)
        						->with('typesAddresses', $typesAddresses);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editDetail()
	{
		$id_organization = Session::get('id_organization');

		if (Session::has('id'))
			$id = Session::get('id');
		else
			$id = Session::get('id_ardent');
		Session::put('id_ardent', $id);

		// Get state for the current city as a default
		$this->model = $this->model->find($id);
		
		$cities = City::where('id_state', '=', $this->model->city->id_state)
							->lists('name', 'id');
		$databases = Auth::user()->getListDatabases();
		$statusAddresses = StatusAddress::where('id_organization', '=', $id_organization)
										->lists('name', 'id');
		$typesAddresses = TypesAddress::where('id_organization', '=', $id_organization)
										->lists('name', 'id');

        return parent::editDetail()->with('id', $id)
        						->with('cities', $cities)
        						->with('databases', $databases)
        						->with('statusAddresses', $statusAddresses)
        						->with('typesAddresses', $typesAddresses);
	}

}

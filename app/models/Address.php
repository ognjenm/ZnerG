<?php

use LaravelBook\Ardent\Ardent;

class Address extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'addresses';
	protected $softDelete = true;
	protected $guarded = array('id', 'activateEditLocationsModal', 'id_tab', 'id_state', 'id_location', 'id_business', 'id_address', 'id_statusLocation', 'phone', 'phoneAdditional', 'fax', 'isHeadquarter', 'isShipping', 'isBilling', 'isActive', 'activateLocationsModal');

	public $fieldName = 'addressLine1';
	public $fieldTextAux = ' Ste. ';
	public $fieldNameAux = 'suite';

	public $filters = array(
		'id_database'				=> 'databases',
	);
	public $filtersWhere = array(
		'id_database'				=> null,
	);
	public $filtersTemp = array(
		'id_databse'				=> 'databases',
	);
	public $wheres = array(
		'id_database'				=> 'databases',
	);
	public $orderBy = array(
		'addressLine1'				=> 'ASC',
	);
	public $autocomplete = array(
		'0' => 'field:addressLine1',
		'1' => 'text: #',
		'2' => 'field:suite',
		'3' => 'text:, ',
		'4' => 'linked:id_city name',
	);
	public static $rules = array(
		'addressLine1'                  => 'required',
	);

	public $arraySearchFields = array('addressLine1', 'addressLine2', 'zipcode', 'reference', 'suite');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

    public function database()
    {
    	return $this->belongsTo('Database', 'id_database', 'id');
    }

    public function city()
    {
    	return $this->belongsTo('City', 'id_city', 'id');
    }

	public function getNameAttribute()
   	{
        return $this->attributes['addressLine1'];
    }

    public function getAddress($geocode, $addressText, $id_database)
    {
		$country = Country::where('name', '=', $geocode->getCountry())
							->get();
		// If there is only 1 country we continue
		if ($country->count() == 0)
		{
		// We create the country.
			$country = new State();
	    	$country->autoHydrateEntityFromInput = false;
	    	$country->forceEntityHydrationFromInput = false;
			$country->name = $geocode->getCountry();
			$country->id_organization = Session::get('id_organization');
			$country->save();
			$id_country = $country->id;
		}
		elseif ($country->count() == 1)
		{
			$country = $country->first();
			$id_country = $country->id;
		}
		$state = State::where('id_country', '=', $id_country)
						->where('name', '=', $geocode->getRegion())
						->get();
		if ($state->count() == 0)
		{
			// We create the state.
			$state = new State();
	    	$state->autoHydrateEntityFromInput = false;
	    	$state->forceEntityHydrationFromInput = false;
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
	    	$city->autoHydrateEntityFromInput = false;
	    	$city->forceEntityHydrationFromInput = false;
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

		$suite = strstr($addressText, '#');
		if ($suite)
		{
			$suite = strstr($suite, ',', true);
			$suite = trim(substr($suite, 1));
		}
		else
			$suite = '';
    	$this->addressLine1 = $addressLine1;
    	$this->id_city = $city->id;
    	$this->zipcode = $zipcode;
   		$this->suite = $suite;
    	$this->latitude = $geocode->getLatitude();
    	$this->longitude = $geocode->getLongitude();    
    	$this->id_database = $id_database;	
    	$this->id_statusAddress = 1;
    	$this->id_typesAddress = 1;
    }

	public function fulltextSearch($tableName, $term, $data)
	{
// 		$searchFields = implode(',', $this->arraySearchFields);
// 		$field = $this->fieldName;

// 		// First determine is there is a field relations for this table
// 		//Field::where('id'
// 		// $array = array('locations' => 'amount');
// 		// $arrayValues = array();
// 		// foreach ($array as $key => $value)
// 		// {
// 		// 	var_dump($key . ':' . $value . '=>' . $data[$value]);
// 		// }
// 		// dd('End');
// 	//	$table = 'locations'
// 	//	$field

// 	    $results = DB::table($tableName)->whereRaw("MATCH(" . $searchFields . ") AGAINST('+{$term}*' IN BOOLEAN MODE)");


// SELECT *, 
//  MATCH(books.title) AGAINST('$q') as tscore,
//  MATCH(authors.authorName) AGAINST('$q') as ascore,
//  MATCH(chapters.content) AGAINST('$q') as cscore
// FROM books 
// LEFT JOIN authors ON books.authorID = authors.authorID 
// LEFT JOIN chapters ON books.bookID = chapters.bookID 
// WHERE 
//  MATCH(books.title) AGAINST('$q')
//  OR MATCH(authors.authorName) AGAINST('$q')
//  OR MATCH(chapters.content) AGAINST('$q')
// ORDER BY (tscore + ascore + cscore) DESC


// 	    // foreach ()
// 	    // {
// 	    // }
// 	    $results = $results->get();
// 		$rows = array();
// 		if ($results)
// 		{
// 			foreach ($results as $index => $value)
// 			{
// 				$rows[] = array (
// 					'id'	=> $value->id,
// 					'value'	=> $value->$field );
// 			}
// 		}
// 		return json_encode($rows);
	}
}

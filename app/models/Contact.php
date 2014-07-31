<?php

use LaravelBook\Ardent\Ardent;

class Contact extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'contacts';
	protected $softDelete = true;
	protected $guarded = array('id', 'position', 'dayMonday', 'dayTuesday', 'dayWednesday', 'dayThursday', 'dayFriday', 'daySaturday', 'start', 'end', 'scheduleNotes', 'id_contact', 'id_tab', 'id_business', 'activateContactsBusinessesModal', 'activateEditContactsBusinessesModal');

	public $fieldName = 'firstName';
	public $auxName = 'lastName';
	
	public $filters = array(
		'id_database'				=> 'databases',
	);
	public $filtersWhere = array(
		'id_database'				=> null,
	);
	public $filtersTemp = array(
		'id_database'				=> 'databases',
	);
	public $wheres = array(
		'id_database'				=> 'databases',
	);
	public $orderBy = array(
		'firstName'				=> 'ASC',
	);
	public $autocomplete = array(
		'0' => 'field:firstName',
		'1' => 'text: ',
		'2' => 'field:lastName',
		'3' => 'text:, ',
		'4' => 'linked:contactsBusinesses=id_contact position',
	);
	public static $rules = array(
		'firstName'                  => 'required',
	);

	public $arraySearchFields = array('firstName', 'lastName', 'phone', 'email');

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

	public function getNameAttribute()
   	{
        return $this->attributes['firstName'] . $this->attributes['lastName'];
    }

    public static function getFirstName($text)
    {
    	$text = trim($text);
    	$firstName = '';
    	$firstName = trim(strstr($text, ' ', true));
    	if (!$firstName)
    	{
    		$firstName = trim(strstr($text, ',', true));
	    	if (!$firstName)
	    		$firstName = trim($text);
    	}
    	else
    	{
    		$aux = trim(strstr($firstName, ',', true));
    		if ($aux)
    			$firstName = $aux;
    	}
    	return $firstName;
    }

    public static function getLastName($text)
    {
    	$text = trim($text);
    	$lastName = '';
    	$firstName = trim(strstr($text, ' ', true));
    	if (strpos($firstName, ','))
    		$lastName = '';
    	elseif ($firstName)
    	{
			$remainingString = substr(strstr($text, ' '),1);
    		$lastName = trim(strstr($remainingString, ',', true));
    		if (!$lastName)
    			$lastName = trim($remainingString);
    	}
    	return $lastName;
    }
}

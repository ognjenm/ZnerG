<?php

use LaravelBook\Ardent\Ardent;

class ContactsBusiness extends Ardent {
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
  	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	protected $table = 'contactsBusinesses';
	protected $softDelete = true;
	// protected $guarded = array();

	public $fieldName = 'position';
	public $filters = array();
	public $filtersWhere = array();
	public $wheres = array();
	public $orderBy = array(
		'position'				=> 'ASC',
	);

	public static $rules = array();

	public $arraySearchFields = array('position', 'scheduleNotes');

	public static function boot()
    {
        parent::boot();

        // Setup event bindings...
		self::observe(new ModelObserver);
    }

    public function contact()
    {
    	return $this->belongsTo('Contact', 'id_contact', 'id');
    }

    public function business()
    {
    	return $this->belongsTo('Business', 'id_business', 'id');
    }

	public function getNameAttribute()
   	{
        return $this->attributes['position'];
    }

    public static function getPosition($text)
    {
    	$text = trim($text);
    	$position = '';
    	$firstName = trim(strstr($text, ' ', true));
    	if (!$firstName)
    	{
    		$firstName = trim(strstr($text, ',', true));
	    	if ($firstName)
		    	$position = trim(substr(strstr($text, ','),1));												    		
    	}
    	else
    	{
	     	if (strpos($firstName, ','))
	    		$position = trim(substr(strstr($text, ','),1));
   			else
   			{
				$remainingString = substr(strstr($text, ' '),1);
	    		$lastName = trim(strstr($remainingString, ',', true));
	    		if ($lastName)
			    	$position = trim(substr(strstr($remainingString, ','),1));
			}
    	}
    	return $position;
    }

}

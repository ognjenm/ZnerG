<?php

use LaravelBook\Ardent\Ardent;

class UserParameter extends Ardent
{
	protected $table = 'userParameters';
	public $incrementing = false;
	protected $guarded = array();

}


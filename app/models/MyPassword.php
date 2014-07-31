<?php

class MyPassword extends Password {

	public static $rules = array(
		'email' => 'required | Between:3,64 | email',
		'password' => 'required | AlphaNum | Between:6,16 | Confirmed',
		'password_confirmation'=> 'Required | AlphaNum | Between:6,16',
		);

	public static $rulesAdditional1 = array(
		'email' => 'required | Between:6,16 | email',
		);

}


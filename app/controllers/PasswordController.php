<?php

require app_path().'/models/MyPassword.php';

class PasswordController extends BaseController {

	protected $password;

	public function __construct()
	{
		$this->password = new MyPassword;
	}

	public function remind()
	{
		return View::make('password.remind');
	}

	public function request()
	{
		$input = Input::all();
		$token = $input['token'];		
		$v = Validator::make($input, MyPassword::$rulesAdditional1);

		if ($v->fails())
			return Redirect::to('password/reset')->withErrors($v);

		$teams = User::whereNull('deleted_at')
					->where(function($query)
					{
					    $input = Input::get('email');
						$query->where('id_organization', Session::get('id_organization'))->where('email', $input);
					})->get();


		if ($teams->count() > 0)
		{
			$credentials = array('email' => $input['email'], 'id_organization' => Session::get('id_organization'));

			return Password::remind($credentials, function($message, $user)
				{
					$message->subject('Your password reminder');
					$message->from('admin@znerg.com',Session::get('shortName'));
				});
		}
		else
			return Redirect::to('password/reset')->with('message', trans('ui.nonexistentEmail'));			
	}

	public function reset($token)
	{
	  return View::make('password.reset')->with('token', $token);
	}

	public function update()
	{
		$input = Input::all();
		$token = $input['token'];
		$v = Validator::make($input, MyPassword::$rules);

		if($v->fails())
			return Redirect::action('PasswordController@reset', array('token' => $token))->withInput()->withErrors($v);

		$teams = User::whereNull('deleted_at')
					->where(function($query)
					{
					    $input = Input::get('email');
						$query->where('id_organization', Session::get('id_organization'))->where('email', $input);
					})->get();


		if ($teams->count() > 0)
		{
			$credentials = array('email' => $input['email'], 'id_organization' => Session::get('id_organization'));

			return Password::reset($credentials, function($user, $password)
			{
				$user->password = Hash::make($password);
				$user->save();
				return Redirect::to('login')->with('message', trans('ui.passwordReset'));
			});
		}
		else
			return Redirect::action('PasswordController@reset', array('token' => $token))->with('message', trans('ui.nonexistentEmail'));
	}

}
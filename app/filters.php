<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	if (!Session::has('activePage'))
		Session::put('activePage', 110);

	if (Input::get('activePage'))
		Session::put('activePage', Input::get('activePage'));
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) 		
	{
		if (Session::has('shortName'))
			return Redirect::guest('login')->with('message', 'You must be logged in to view this page');
		else
			return Redirect::guest('/')->with('message', 'You must enter the correct url to access to the system');
	}
});

Route::filter('access', function()
{
	$menuOptions = Session::get('menuOptions');

	$modelName = strstr(Route::current()->getUri(), '.', true);	
	if (!$modelName)
	{
		$modelName = strstr(Route::current()->getUri(), '/', true);	
		if (!$modelName)
			$modelName = Route::current()->getUri();

		// 4.0 needed to delete a space -> $modelName = substr($modelName, strpos($modelName,' ') + 1);	
	}
	//	4.0 function -> currentRouteName
	Session::put('modelName', $modelName);
	$access = 0;
	foreach($menuOptions as $key => $value)
	{
		if (isset($value['link']) && $value['link'] == $modelName)
		{
			if  ($value['authExecute'] == 1)
			{				
				Session::put('authExecute', 1);
				$access = 1;
			}
			else
				Session::put('authExecute', 0);
			
			if  ($value['authInsert'] == 1)
				Session::put('authInsert', 1);
			else
				Session::put('authInsert', 0);

			if  ($value['authUpdate'] == 1)
				Session::put('authUpdate', 1);
			else
				Session::put('authUpdate', 0);

			if  ($value['authDelete'] == 1)
				Session::put('authDelete', 1);
			else
				Session::put('authDelete', 0);

			break;
		}
	}	
	if ($access == 0)
	{
		return View::make('home.errorMaster')->with('error', trans('ui.yourUserHaveNoAccessToAnyMenuOption'));
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|-----------------------------------------	---------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
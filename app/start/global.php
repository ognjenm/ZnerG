<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',
	app_path().'/library',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

$logFile = 'log-ZnerG.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/


App::error(function(Exception $exception, $code)
{	
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| If there is a route not supported
|--------------------------------------------------------------------------
|
| Show a message of error and a button to send you to the main page
|
*/

App::missing(function($exception)
{
	if (Auth::check())
		return View::make('home.errorMaster');		
	else
		return View::make('home.errorWebsite');		
});


/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

// Loading parameters and adding '_' prefix

// Verify you are logged in and get the userid
if (Auth::check())
{

	/*
	|--------------------------------------------------------------------------
	| Register all the models that we want to Log
	|--------------------------------------------------------------------------
	|
	| There is on class dedicated to record the log for each event affecting the
	| model.
	|
	*/
	// Load Parameters for the user
	Auth::user()->loadParameters();

	if (Session::has('_inmediateMenuUpdate'))
	{
		if (Session::get('_inmediateMenuUpdate') == 'Yes')
		{
			// Load Menu access
			Auth::user()->loadMenu();			
		}
	}

}


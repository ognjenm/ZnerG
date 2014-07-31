<?php

class WorkflowsController extends Controller {

	public function __construct(Workflow $model)
	{
		$this->model = $model;
	}
		/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$modelName = Session::get('modelName');	

		$lat = 0;
		$lon = 0;
		$error = '';

        return View::make($modelName. '.index', compact('modelName', 'geocode', 'error', 'lat', 'lon'));
	}

	public function getSearch()
	{
		$modelName = Session::get('modelName');	

		$lat = Input::get('lat');
		$lon = Input::get('lon');
		try {
 		   $geocode = Geocoder::reverse($lat, $lon);

		    // ...
		} catch (\Exception $e) {
		    // Here we will get "The FreeGeoIpProvider does not support Street addresses." ;)
		    $error = $e->getMessage();
		}	

        return View::make($modelName. '.index', compact('modelName', 'geocode', 'error', 'lat', 'lon'));
	}

}

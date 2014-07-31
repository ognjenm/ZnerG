<?php

class LocationsController extends ArdentController {

	public function __construct(Location $model)
	{
		$this->model = $model;
	}

	public function destroy($id)
	{
		Session::put('modelName', 'businesses');
		return parent::destroy($id);
	}
}

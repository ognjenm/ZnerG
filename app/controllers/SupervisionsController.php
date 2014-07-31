<?php

class SupervisionsController extends ArdentController {

	public function __construct(Supervision $model)
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

        return View::make($modelName. '.index', compact('modelName'));
	}
}

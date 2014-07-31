<?php

class ReportsController extends Controller {

	public function __construct(Report $model)
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

		$modelData = DB::table('workdays')
						->where('id_employee', '=', Auth::user()->id_employee)
						->orderBy('Date', 'ASC')
						->get();
        return View::make($modelName. '.index', compact('modelName', 'modelData'));
	}

	public function getSearch()
	{
		$modelName = Session::get('modelName');	

		$modelData = DB::table('workdays')
						->where('id_employee', '=', Auth::user()->id_employee)
						->orderBy('Date', 'ASC')
						->get();

        return View::make($modelName. '.index', compact('modelName', 'modelData'));
	}

}

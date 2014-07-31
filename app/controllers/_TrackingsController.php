<?php

class TrackingsController extends BaseController {

	protected $tracking;

	public function __construct(Option $tracking)
	{
		$this->tracking = $tracking;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('trackings.index');
	}

}

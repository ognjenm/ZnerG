<?php

class ActivitiesController extends ArdentController {

	public function __construct(Activity $model)
	{
		$this->model = $model;
	}

	public function createDetail()
	{
		$typesActivities = TypesActivity::lists('name', 'id');

        return parent::createDetail()->with('typesActivities', $typesActivities);
	}

	public function show($id)
	{
		$typesActivities = TypesActivity::lists('name', 'id');

        return parent::show($id)->with('typesActivities', $typesActivities);
	}

	public function editDetail()
	{
		$id = Session::get('id');
		$typesActivities = TypesActivity::lists('name', 'id');

        return parent::editDetail()->with('id', $id)
        							->with('typesActivities', $typesActivities);
	}


}

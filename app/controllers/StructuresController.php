<?php

class StructuresController extends ArdentController {

	public function __construct(Structure $model)
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
		// Update the table with the latest structures
		$this->model->updateStatus();

		return parent::index();
	}

	public function save()
	{
		$records = Input::get('records');

		// Update visible flag
		if (is_array($records))
		{
			foreach ($records as $key => $value)
			{
				$index = substr($value, 0, 1);
				if ($index == 'Y')
				{
					$value = substr($value, 1);
					$this->model = $this->model->find($value);
					$this->model->isVisible = 1;
				}
				else
				{
					$this->model = $this->model->find($value);
					$this->model->isVisible = 0;
				}
				$this->model->autoHydrateEntityFromInput = false;    // hydrates on new entries' validation
				$this->model->forceEntityHydrationFromInput = false; // hydrates whenever validation is called
				$this->model->save();
			}
		}
		return self::index();
	}
}

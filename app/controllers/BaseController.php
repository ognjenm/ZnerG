<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function index()
	{
		$input = Input::get('searchField');
	    if (!$input)
			$input = "";
		
		$modelName = Session::get('modelName');	
		$tableName = $modelName;	

		// Load the filters with the last value
		$id_filterValues = array();
		foreach($this->model->filters as $key => $value)
			$id_filterValues[$key] = null;

		// Load the wheres with the last value
		$id_whereValues = array();
		foreach($this->model->wheres as $key => $value)
			$id_whereValues[$key] = null;

		// Load data for filters
		$dataArray = array();
		foreach($this->model->filters as $key => $value)
		{				
			$data = DB::table($value);
			$row = DB::table($value);
			foreach($this->model->filtersWhere as $keyFiltersWhere => $valueFiltersWhere)
			{
				if ($key == $keyFiltersWhere)
				{
					if ($valueFiltersWhere)
					{
						foreach($valueFiltersWhere as $k => $v)
						{
							// if different than null or 0, that it, All rows
							if ($id_filterValues[$v])
							{
								$data = $data->where($v, $id_filterValues[$v]);
								$row = $row->where($v, $id_filterValues[$v]);
							}
						}
					}
				}
			}
			$row = $row->first();
			$arrayTemp = array();
			if (array_key_exists('id_organization', $id_filterValues))
			{
				if (Auth::user()->id != 1)
					$data = $data->where('id', '=', Auth::user()->id_organization);
			}
			$data = $data->lists('name', 'id');
			if (count($data) > 0)
			{
				if (Auth::user()->id == 1 || $key != 'id_organization')
				{
					$arrayTemp = array('0' => 'All ' . $value);
					$valueFiltersWhere[$key] = 0;
					if (isset($id_whereValues[$key]))
						$id_whereValues[$key] = 0;
				}
				else
				{
					$valueFiltersWhere[$key] = $row->id;
					if (isset($id_whereValues[$key]))
						$id_whereValues[$key] = $row->id;
				}
			}
			else
			{
				$arrayTemp = array('-1' => 'No ' . $value . ' defined');
				$valueFiltersWhere[$key] = -1;
				$id_whereValues[$key] = -1;
			}
			Session::put($key.'Selected', $valueFiltersWhere[$key]);
			$data = $arrayTemp + $data;
			$dataArray[$key] = $data;
		}

		// Select only not deleted rows
		$modelData = $this->model->whereNull($this->model->getTable().'.deleted_at');

		// Use of wheres
		foreach($id_whereValues as $key => $value)
		{
			if (is_array($this->model->wheres[$key]))
				$modelData = $modelData->whereIn($key, $this->model->wheres[$key]);
			elseif ($value > 0)
				$modelData = $modelData->where($key, '=', $value);
		}
		// If it is a user from an specific organization, it can't have access to other organization's users
		if (array_key_exists('id_organization', $id_whereValues))
		{
			if (Auth::user()->id != 1)
			$modelData = $modelData->where('id_organization', '=', Auth::user()->id_organization);
		}

		// Use of orderBy
		foreach ($this->model->orderBy as $key => $value)
		{
			$modelData = $modelData->orderBy($key, $value);
		}

		$modelData = $modelData->paginate(Session::get('_numRowsPagination'));
		Session::put('nestedRoutePath', $modelName. '.index');	
	
        return View::make($modelName. '.index', compact('modelName', 'modelData', 'tableName', 'dataArray', 'id_filterValues', 'id_whereValues', 'input'));
	}

	public function getSearch()
	{
	    $input = Input::get('searchField');
	    if (!$input)
			$input = "";

    	$modelName = Session::get('modelName');	
		$tableName = $modelName;	

		// Load the filters with the last value
		$id_filterValues = array();
		foreach($this->model->filters as $key => $value)
		{
			Session::put($key . 'Selected', Input::get($key));
			$id_filterValues[$key] = Input::get($key);
		}

		// Load the wheres with the last value
		$id_whereValues = array();
		foreach($this->model->wheres as $key => $value)
		{
			Session::put($key . 'Selected', Input::get($key));
			$id_whereValues[$key] = Input::get($key);
		}

		// Load data for filters
		$dataArray = array();
		foreach($this->model->filters as $key => $value)
		{				
			$data = DB::table($value);
			$row = DB::table($value);
			foreach($this->model->filtersWhere as $keyFiltersWhere => $valueFiltersWhere)
			{
				if ($key == $keyFiltersWhere)
				{
					if ($valueFiltersWhere)
					{
						foreach($valueFiltersWhere as $k => $v)
						{
							// if different than null or 0, that it, All rows
							if ($id_filterValues[$v])
							{
								$data = $data->where($v, $id_filterValues[$v]);
								$row = $row->where($v, $id_filterValues[$v]);
							}
						}
					}
				}
			}
			$row = $row->first();
			$arrayTemp = array();
			if (array_key_exists('id_organization', $id_filterValues))
			{
				if (Auth::user()->id != 1)
				$data = $data->where('id', '=', Auth::user()->id_organization);
			}
			$data = $data->lists('name', 'id');
			if (count($data) > 0)
			{
				if (Auth::user()->id == 1 || $key != 'id_organization')
				{
					$arrayTemp = array('0' => 'All ' . $value);
					$valueFiltersWhere[$key] = 0;
					if (isset($id_filterValues[$key]) && isset($id_whereValues[$key]) && $id_filterValues[$key] > 0)
						$id_whereValues[$key] = $id_filterValues[$key];
					elseif (isset($id_whereValues[$key]))
						$id_whereValues[$key] = 0;
				}
				else
				{
					$valueFiltersWhere[$key] = $row->id;
					if (isset($id_filterValues[$key]) && isset($id_whereValues[$key]) && $id_filterValues[$key] > 0)
						$id_whereValues[$key] = $id_filterValues[$key];
					elseif (isset($id_whereValues[$key]))
						$id_whereValues[$key] = $row->id;
				}
			}
			else
			{
				$arrayTemp = array('-1' => 'No ' . $value . ' defined');
				$valueFiltersWhere[$key] = -1;
				$id_whereValues[$key] = -1;
			}
			Session::put($key.'Selected', $valueFiltersWhere[$key]);
			$data = $arrayTemp + $data;
			$dataArray[$key] = $data;
		}

		// Select only not deleted rows
		$modelData = $this->model->whereNull($this->model->getTable().'.deleted_at');

		// Use of wheres
		foreach($id_whereValues as $key => $value)
		{
			if (is_array($this->model->wheres[$key]))
				$modelData = $modelData->whereIn($key, $this->model->wheres[$key]);
			elseif ($value <> 0)
				$modelData = $modelData->where($key, '=', $value);
		}

		if (array_key_exists('id_organization', $id_whereValues))
		{
			if (Auth::user()->id != 1)
			$modelData = $modelData->where('id_organization', '=', Auth::user()->id_organization);
		}

		// Search for input
		$arraySearchFields = $this->model->arraySearchFields;
		$modelData = $modelData->where(function($query) use ($input, $arraySearchFields)
								{
									$query->where($this->model->fieldName, 'LIKE', '%'.$input.'%');							
									foreach ($arraySearchFields as $term)
									{
										if ($term != $this->model->fieldName)
											$query->orWhere($term, 'LIKE', '%'.$input.'%');
									}
								});

		// Use of orderBy
		foreach ($this->model->orderBy as $key => $value)
		{
			$modelData = $modelData->orderBy($key, $value);
		}

		$modelData = $modelData->paginate(Session::get('_numRowsPagination'));
		Session::put('nestedRoutePath', $modelName. '.index');	
		
        return View::make($modelName. '.index', compact('modelName', 'modelData', 'tableName', 'dataArray', 'id_filterValues', 'id_whereValues', 'input'));
	}

	public function create()
	{
		$modelName = Session::get('modelName');	
		return Redirect::to($modelName . '/createDetail')->with('nestedCall', 'No')
															->with('nestedRoute', $modelName . '.index');
	}

	public function createDetail()
	{
		$modelName = Session::get('modelName');	

		// Determine with route to comeback after creating/editing/canceling
		if (!Session::has('nestedCall'))
		{
			if (Session::get('nestedRoute'))
				Session::put('nestedRoutePath', Session::get('nestedRoute'));
			else
				Session::put('nestedRoutePath', $modelName . '.index');
		}
		else if (Session::get('nestedCall') == 'Yes' || Session::get('nestedCallSaved') == 'Yes')
		{
			Session::put('nestedRoutePath', Session::get('nestedRoute'));
			Session::put('nestedCallSaved', 'Yes');
		}
		else
		{
			Session::put('nestedRoutePath', $modelName . '.index');
			Session::put('nestedCallSaved', 'No');
		}
		$tableName = $modelName;	
		$organizations = Organization::lists('name', 'id');
        return View::make($modelName. '.create', compact('modelName', 'tableName', 'organizations'));
	}

	public function edit($id)
	{
		$modelName = Session::get('modelName');	
		Session::put('message', Session::get('message'));
		Session::put('id', $id);	
		return Redirect::to($modelName . '/editDetail')->with('nestedCall', 'No')
														->with('nestedRoute', $modelName . '.index')
														->with('message', Session::get('message'));
	}

	public function editDetail()
	{
		$modelName = Session::get('modelName');	

		if (Session::has('id'))
			$id = Session::get('id');
		else
			$id = Session::get('id_base');

		// Determine with route to comeback after creating/editing/canceling
		if (!Session::has('nestedCall'))
		{
			if (Session::get('nestedRoute'))
				Session::put('nestedRoutePath', Session::get('nestedRoute'));
			else
				Session::put('nestedRoutePath', $modelName . '.index');
		}
		else if (Session::get('nestedCall') == 'Yes' || Session::get('nestedCallSaved') == 'Yes')
		{
			Session::put('nestedRoutePath', Session::get('nestedRoute'));
			Session::put('nestedCallSaved', 'Yes');
		}
		else
		{
			Session::put('nestedRoutePath', $modelName . '.index');
			Session::put('nestedCallSaved', 'No');
		}
		$tableName = $modelName;
		$organizations = Organization::lists('name', 'id');

		$tableName = $modelName;	
		$model = $this->model->find($id);

		//dd($this->model);	
		if (is_null($model))
			return Redirect::route($modelName. '.index');
		$id_organization = $model->id_organization;
		$organizations = Organization::lists('name', 'id');

        return View::make($modelName. '.edit', compact('model', 'modelName', 'tableName', 'organizations', 'message'));
	}

	public function back()
	{
		if (Session::has('instanceData'))
		{
			$instanceData = Session::get('instanceData');
			if (isset($instanceData['id']))
			{
				$id = $instanceData['id'];
				return Redirect::route(Session::get('nestedRoutePath'), $id)->with('id', $id)
																			->withInput(Session::get('instanceData'));
			}
		}
		return Redirect::route(Session::get('nestedRoutePath'))->withInput(Session::get('instanceData'));
																
	}
}

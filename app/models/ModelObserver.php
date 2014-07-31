<?php

class ModelObserver
{

	public function creating($model)
	{
			// if there is any validation before this event, put it in here		
	}
	public function created($model)
	{
			$message = Session::get('shortName') . ', ';
			if (Auth::check())
				$message = $message . Auth::user()->username . ', ';
			else
				$message = $message . '<none>, ';
			$message = $message . ucfirst(__FUNCTION__) . ', ';
			$message = $message . $model->getTable() . ', ';
			$attributes = $model->getAttributes();
			$message = $message . $attributes['id'];
			Log::info($message);	
	}
	public function updating($model)
	{
			// if there is any validation before this event, put it in here		
	}
	public function updated($model)
	{
			$message = Session::get('shortName') . ', ';
			if (Auth::check())
				$message = $message . Auth::user()->username . ', ';
			else
				$message = $message . '<none>, ';
			$message = $message . ucfirst(__FUNCTION__) . ', ';
			$message = $message . $model->getTable() . ', ';
			$attributes = $model->getAttributes();
			$message = $message . $attributes['id'];
			Log::info($message);		
	}
	public function saving($model)
	{
			// if there is any validation before this event, put it in here		
	}
	public function saved($model)
	{
			// Saved is called after Created or Updated is called, so it is redundant
	}
	public function deleting($model)
	{
			// if there is any validation before this event, put it in here		
	}
	public function deleted($model)
	{
			$message = Session::get('shortName') . ', ';
			if (Auth::check())
				$message = $message . Auth::user()->username . ', ';
			else
				$message = $message . '<none>, ';
			$message = $message . ucfirst(__FUNCTION__) . ', ';
			$message = $message . $model->getTable() . ', ';
			$attributes = $model->getAttributes();
			$message = $message . $attributes['id'];
			Log::info($message);		
	}
	public function restoring($model)
	{
			// if there is any validation before this event, put it in here		
	}
	public function restored($model)
	{
			$message = Session::get('shortName') . ', ';
			if (Auth::check())
				$message = $message . Auth::user()->username . ', ';
			else
				$message = $message . '<none>, ';
			$message = $message . ucfirst(__FUNCTION__) . ', ';
			$message = $message . $model->getTable() . ', ';
			$attributes = $model->getAttributes();
			$message = $message . $attributes['id'];
			Log::info($message);		
	}
}


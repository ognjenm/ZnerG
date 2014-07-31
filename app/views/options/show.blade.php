@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
	</div>
	{{ Form::model($model, array('method' => 'DELETE', 'route' => array($modelName . '.destroy', $model->id), 'class' => 'form-horizontal form-standard')) }}
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldText', array('info' => array('name' => 'link', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isPublished', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldText', array('info' => array('name' => 'version', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldText', array('info' => array('name' => 'startDate', 'sLabel' => '3', 'sField' => '2', 'class' => 'startDate')))
	@include('elements.fieldText', array('info' => array('name' => 'endDate', 'sLabel' => '3', 'sField' => '2', 'class' => 'endDate')))
	<div class="form-group">
		<div class="col-offset-2 col-7">
			@include('elements.editButtonForm')
			@include('elements.deleteButtonForm')
			@include('elements.cancelButtonForm')
		</div>		
	</div>
	{{ Form::close() }}
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop

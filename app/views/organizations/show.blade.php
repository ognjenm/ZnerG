@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
	</div>
	{{ Form::model($model, array('method' => 'DELETE', 'route' => array($modelName . '.destroy', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}

	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldText', array('info' => array('name' => 'shortName', 'sLabel' => '3', 'sField' => '4')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isSystem', 'sLabel' => '3', 'sField' => '2')))
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
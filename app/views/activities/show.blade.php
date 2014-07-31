@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::model($model, array('method' => 'DELETE', 'route' => array($modelName . '.destroy', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('mode' => 'edit', 'name' => 'name', 'sLabel' => '3', 'sField' => '7')))
	@if (Auth::user()->id_organization == 1)
		@include('elements.fieldSelect', array('info' => array('name' => 'id_organization', 'sLabel' => '3', 'sField' => '4', 'data' => $organizations)))	
    @else
    	{{ Form::hidden('id_organization', Auth::user()->id_organization) }}
    @endif
	@include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_typesActivity', 'sLabel' => '3', 'sField' => '4', 'data' => $typesActivities)))	
	@include('elements.fieldSelect', array('info' => array('name' => 'isSystem', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
	<div class="form-group col-12">
		<div class="col-offset-1 col-12">
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
@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.create' . ucfirst($modelName)) }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::open(array('route' => $modelName . '.store', 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	<div class="tab-content">
		@include('elements.fieldSelect', array('info' => array('name' => 'id_database', 'sLabel' => '3', 'sField' => '9', 'data' => $databases)))
		@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
		@include('elements.fieldText', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
		@if ($typesBusinesses)
			@include('elements.fieldSelect', array('info' => array('name' => 'id_typesBusiness', 'sLabel' => '3', 'sField' => '9', 'data' => $typesBusinesses)))
		@endif
		@include('elements.fieldText', array('info' => array('name' => 'foundation', 'sLabel' => '3', 'sField' => '5', 'class' => 'datePicker')))
		@include('elements.fieldText', array('info' => array('name' => 'numberEmployees', 'sLabel' => '3', 'sField' => '5', 'class' => '')))
		@include('elements.fieldText', array('info' => array('name' => 'email', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
		@include('elements.fieldText', array('info' => array('name' => 'website', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
		@include('elements.fieldTextarea', array('info' => array('name' => 'note', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
	</div>
	<div class="form-group">
		<div class="col-offset-2 col-7">
			@include('elements.updateButtonForm')
			@include('elements.cancelButtonForm')
		</div>		
	</div>
	{{ Form::close() }}
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop
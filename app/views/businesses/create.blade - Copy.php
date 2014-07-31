@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.create' . ucfirst($modelName)) }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::open(array('url' => array($modelName . '/create'),
					 'method' => 'GET',
					 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm',
					 'id' => 'searchForm', 'name' => 'searchForm')) }}
	@include('elements.fieldTextActive', array('info' => array('name' => 'zipcode', 'sLabel' => '3', 'sField' => '3', 'value' => $zipcode, 'event' => 'onblur', 'function' => 'ddField();')))
	{{ Form::close() }}
	{{ Form::open(array('route' => $modelName . '.store', 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldSelect', array('info' => array('name' => 'id_database', 'sLabel' => '3', 'sField' => '3', 'data' => $databases)))
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_address', 'sLabel' => '3', 'sField' => '5', 'data' => $addresses)))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_statusLocation', 'sLabel' => '3', 'sField' => '2', 'data' => $statusLocations)))
	@include('elements.fieldSelect', array('info' => array('name' => 'isHeadquarter', 'sLabel' => '3', 'sField' => '2', 'entity' => 'locations')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isBilling', 'sLabel' => '3', 'sField' => '2', 'entity' => 'locations')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isShipping', 'sLabel' => '3', 'sField' => '2', 'entity' => 'locations')))
	@include('elements.fieldText', array('info' => array('name' => 'email', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
	@include('elements.fieldText', array('info' => array('name' => 'website', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
	@include('elements.fieldTextarea', array('info' => array('name' => 'note', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2', 'entity' => 'locations')))
	<div class="form-group">
		<div class="col-offset-2 col-7">
			@include('elements.updateButtonForm')
			@include('elements.cancelButtonForm')
		</div>		
	</div>
   	{{ Form::hidden('zipcode', $zipcode); }}
	{{ Form::close() }}
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop
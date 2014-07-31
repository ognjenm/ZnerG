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
	@include('elements.fieldSelectActive', array('info' => array('name' => 'id_state', 'value' => $id_state, 'sLabel' => '3', 'sField' => '9', 'data' => $states, 'value' => $id_state, 'event' => 'onchange', 'function' => 'ddField();')))
	{{ Form::close() }}
	{{ Form::open(array('route' => $modelName . '.store', 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldSelect', array('info' => array('name' => 'id_city', 'value' => $id_city, 'sLabel' => '3', 'sField' => '9', 'data' => $cities)))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_database', 'sLabel' => '3', 'sField' => '9', 'data' => $databases)))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_statusAddress', 'sLabel' => '3', 'sField' => '9', 'data' => $statusAddresses)))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_typesAddress', 'sLabel' => '3', 'sField' => '9', 'data' => $typesAddresses)))
	@include('elements.fieldText', array('info' => array('name' => 'addressLine1', 'value' => $addressLine1, 'sLabel' => '3', 'sField' => '9', 'class' => '')))
	@include('elements.fieldText', array('info' => array('name' => 'addressLine2', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
	@include('elements.fieldText', array('info' => array('name' => 'suite', 'sLabel' => '3', 'sField' => '5', 'class' => '')))
	@include('elements.fieldText', array('info' => array('name' => 'zipcode', 'value' => $zipcode, 'sLabel' => '3', 'sField' => '5', 'class' => '')))
	@include('elements.fieldTextarea', array('info' => array('name' => 'reference', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
	<div class="form-group">
		<div class="col-offset-2 col-7">
			@include('elements.updateButtonForm')
			@include('elements.cancelButtonForm')
		</div>		
	</div>
	{{ Form::hidden('latitude', null, array('class' => 'form-control', 'id' => 'latitude')) }}
	{{ Form::hidden('longitude', null, array('class' => 'form-control', 'id' => 'longitude')) }}
   	{{ Form::hidden('id_state', $id_state); }}
	{{ Form::close() }}
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop
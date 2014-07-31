@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ ucfirst($metaDataName) . ': ' . trans('ui.creating') . ' ' . ucfirst($modelName) }}</h4>
	</div>
	@include('elements.messages')
	
	{{ Form::open(array('url' => array($modelName . '/create'),
					 'method' => 'GET',
					 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm',
					 'id' => 'filterForm', 'name' => 'filterForm')) }}
		@include('elements.fieldSelectActive', array('info' => array('name' => 'id_typesApplication', 'sLabel' => '3', 'sField' => '3', 'value' => $filter, 'data' => $typesApplications, 'event' => 'onchange', 'function' => 'ddFilter();')))
	{{ Form::close() }}

	{{ Form::open(array('route' => $modelName . '.store', 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
    @include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
    @if ($typesApplicationName == 'External')
		@include('elements.fieldText', array('info' => array('name' => 'externalReference', 'sLabel' => '3', 'sField' => '7')))
	@endif
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
	<div class="form-group">
		<div class="col-offset-2 col-7">
			@include('elements.updateButtonForm')
			@include('elements.cancelButtonForm')
		</div>		
	</div>
   	{{ Form::hidden('id_metaData', $id_metaData); }}
   	{{ Form::hidden('id_typesApplication', $filter); }}
	{{ Form::close() }}
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop
@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ ucfirst($metaDataName) . ': ' . trans('ui.editing') . ' ' . ucfirst($modelName) }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::open(array('url' => array($modelName . '/' . $id_field . '/edit'),
					 'method' => 'GET',
					 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm',
					 'id' => 'filterForm', 'name' => 'filterForm')) }}
		@include('elements.fieldSelectActive', array('info' => array('name' => 'isLinked', 'sLabel' => '3', 'sField' => '2', 'value' => $filter, 'event' => 'onchange', 'function' => 'ddFilter();')))
	{{ Form::hidden('id', $id_field) }}
	{{ Form::close() }}

	{{ Form::model($model, array('method' => 'PATCH', 'route' => array($modelName . '.update', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
    @include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
    @if ($filter == 'No')
		@include('elements.fieldSelect', array('info' => array('name' => 'id_dataType', 'sLabel' => '3', 'sField' => '3', 'data' => $dataTypes)))
		@include('elements.fieldText', array('info' => array('name' => 'length', 'sLabel' => '3', 'sField' => '2')))
		@include('elements.fieldText', array('info' => array('name' => 'precision', 'sLabel' => '3', 'sField' => '2')))
		@include('elements.fieldText', array('info' => array('name' => 'scale', 'sLabel' => '3', 'sField' => '2')))
		@include('elements.fieldText', array('info' => array('name' => 'values', 'sLabel' => '3', 'sField' => '7')))
		@include('elements.fieldText', array('info' => array('name' => 'default', 'sLabel' => '3', 'sField' => '7')))
	@else
		@include('elements.fieldSelect', array('info' => array('name' => 'id_structure', 'sLabel' => '3', 'sField' => '4', 'data' => $structures)))
		@include('elements.fieldSelect', array('info' => array('name' => 'isCreatable', 'sLabel' => '3', 'sField' => '2')))
		@include('elements.fieldSelect', array('info' => array('name' => 'isEditable', 'sLabel' => '3', 'sField' => '2')))
		@include('elements.fieldSelect', array('info' => array('name' => 'isDeletable', 'sLabel' => '3', 'sField' => '2')))
		@include('elements.fieldSelect', array('info' => array('name' => 'isFullSearch', 'sLabel' => '3', 'sField' => '2')))
	@endif
	@include('elements.fieldSelect', array('info' => array('name' => 'isNullable', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isReference', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldText', array('info' => array('name' => 'positionReference', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldText', array('info' => array('name' => 'positionUI', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isVisible', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isDisabled', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
	<div class="form-group col-12">
		<div class="col-offset-1 col-12">
			@include('elements.updateButtonForm')
			@include('elements.deleteButtonForm')
			@include('elements.cancelButtonForm')
		</div>		
	</div>
    {{ Form::hidden('id_metaData', $id_metaData); }}
  	{{ Form::hidden('isLinked', $filter); }}
	{{ Form::close() }}
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop
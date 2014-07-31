@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ ucfirst($metaDataName) . ': ' . trans('ui.showing') . ' ' . ucfirst($modelName) }}</h4>
	</div>
	{{ Form::model($model, array('method' => 'DELETE', 'route' => array($modelName . '.destroy', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldSelect', array('info' => array('name' => 'id_typesApplication', 'sLabel' => '3', 'sField' => '3', 'value' => $filter, 'data' => $typesApplications)))
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
    @include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
    @if ($typesApplicationName == 'External')
			@include('elements.fieldText', array('info' => array('name' => 'externalReference', 'sLabel' => '3', 'sField' => '7')))
	@endif
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
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
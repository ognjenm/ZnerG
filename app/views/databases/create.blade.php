@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.create' . ucfirst($modelName)) }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::open(array('route' => $modelName . '.store', 'class' => 'form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '8')))
    @include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '8')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '3')))
	<div class="text-center">
		@include('elements.updateButtonForm')
		@include('elements.cancelButtonForm')
	</div>		
	{{ Form::close() }}
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop
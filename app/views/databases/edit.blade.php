@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::model($model, array('method' => 'PATCH', 'route' => array($modelName . '.update', $model->id), 'class' => 'form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '8')))
    @include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '8')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '3')))
	<div class="text-center">
		@include('elements.updateButtonForm')
		@include('elements.deleteButtonForm')
		<button class="btn btn-xs btn-primary sameSizeButton" data-toggle="modal" data-target="#addressesModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.addresses') }}</button>
		@include('elements.cancelButtonForm')
	</div>
	{{ Form::close() }}

@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop
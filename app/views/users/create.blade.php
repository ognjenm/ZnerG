@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.create' . ucfirst($modelName)) }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::open(array('route' => $modelName . '.store', 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('name' => 'username', 'sLabel' => '3', 'sField' => '7')))
	@if (Auth::user()->id_organization == 1)
		@include('elements.fieldSelect', array('info' => array('name' => 'id_organization', 'sLabel' => '3', 'sField' => '4', 'data' => $organizations)))
    @else
    	{{ Form::hidden('id_organization', Auth::user()->id_organization); }}
    @endif
	@include('elements.fieldSelect', array('info' => array('name' => 'id_employee', 'sLabel' => '3', 'sField' => '4', 'data' => $employees)))
	@include('elements.fieldText', array('info' => array('name' => 'email', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldPassword', array('info' => array('name' => 'password', 'sLabel' => '3', 'sField' => '4')))
	@include('elements.fieldPassword', array('info' => array('name' => 'password_confirmation', 'sLabel' => '3', 'sField' => '4', 'confirmation' => 'Yes')))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_recoveryQuestion', 'sLabel' => '3', 'sField' => '7', 'data' => $recoveryQuestions)))
	@include('elements.fieldText', array('info' => array('name' => 'answer', 'sLabel' => '3', 'sField' => '4')))
	@include('elements.fieldText', array('info' => array('name' => 'alternativeId', 'sLabel' => '3', 'sField' => '3')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isSystem', 'sLabel' => '3', 'sField' => '2')))
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
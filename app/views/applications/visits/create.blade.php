@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.Register') . ' ' . ucfirst($modelName) }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::open(array('route' => $modelName . '.store', 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
   	{{ Form::hidden('id_organization', Auth::user()->id_organization); }}
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
    @include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldText', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldText', array('info' => array('name' => 'isSystem', 'sLabel' => '3', 'sField' => '2')))
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
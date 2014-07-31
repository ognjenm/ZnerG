@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.create' . ucfirst($modelName)) }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::open(array('route' => $modelName . '.store', 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
	@if (Auth::user()->id == 1)
		@include('elements.fieldSelect', array('info' => array('name' => 'id_organization', 'sLabel' => '3', 'sField' => '4', 'data' => $organizations)))
    @else
    	{{ Form::hidden('id_organization', Auth::user()->id_organization); }}
    @endif
    @include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
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
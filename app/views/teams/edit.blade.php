@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::model($model, array('method' => 'PATCH', 'route' => array($modelName . '.update', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldText', array('info' => array('name' => 'startDate', 'sLabel' => '3', 'sField' => '2', 'class' => 'startDate')))
	@include('elements.fieldText', array('info' => array('name' => 'endDate', 'sLabel' => '3', 'sField' => '2', 'class' => 'endDate')))
	<div class="form-group">
		<div class="col-offset-1 col-12">
			@include('elements.updateButtonForm')
			@include('elements.deleteButtonForm')
			<button class="btn btn-primary sameSizeButton" data-toggle="modal" data-target="#usersModal">{{ trans('ui.users') }}</button>

			{{ link_to_route($modelName . '.index', trans('ui.assignPeople'), null, array('class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target'=>'#myModal')) }}
			@include('elements.cancelButtonForm')
		</div>		
	</div>
	{{ Form::close() }}
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
	{{ HTML::script('js/bootstrap-datepicker.js')}}
	<script>
		if (top.location != location) {
	    	top.location.href = document.location.href;
	  	}
	</script>
@stop
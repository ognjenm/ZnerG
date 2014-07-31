@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.create' . ucfirst($modelName)) }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::open(array('url' => array($modelName . '/createByOrganization'),
					 'method' => 'GET',
					 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm',
					 'id' => 'searchForm', 'name' => 'searchForm')) }}
	@if (Auth::user()->id_organization == 1)
		@include('elements.fieldSelectActive', array('info' => array('name' => 'id_organization', 'sLabel' => '3', 'sField' => '4', 'data' => $organizations, 'value' => $id_organization, 'event' => 'onchange', 'function' => 'ddOrganization();')))
    @else
    	{{ Form::hidden('id_organization', Auth::user()->id_organization) }}
    @endif
	{{ Form::close() }}
	{{ Form::open(array('route' => $modelName . '.store', 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7', 'class' => '', 'required' => 'required')))
	@include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_metaData', 'sLabel' => '3', 'sField' => '4', 'data' => $metaDatas)))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_initialActivity', 'sLabel' => '3', 'sField' => '4', 'data' => $activities)))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_finalActivity', 'sLabel' => '3', 'sField' => '4', 'data' => $activities)))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_typesProcess', 'sLabel' => '3', 'sField' => '4', 'data' => $typesProcesses)))
	@include('elements.fieldSelect', array('info' => array('name' => 'audit', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldSelect', array('info' => array('name' => 'log', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
	@include('elements.fieldText', array('info' => array('name' => 'startDate', 'sLabel' => '3', 'sField' => '2', 'class' => 'startDate')))
	@include('elements.fieldText', array('info' => array('name' => 'endDate', 'sLabel' => '3', 'sField' => '2', 'class' => 'endDate')))
	<div class="form-group">
		<div class="col-offset-2 col-7">
			@include('elements.updateButtonForm')
			@include('elements.cancelButtonForm')
		</div>		
	</div>
   	{{ Form::hidden('id_organization', $id_organization); }}
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
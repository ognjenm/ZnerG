@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::model($model, array('method' => 'DELETE', 'route' => array($modelName . '.destroy', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
    @include('elements.fieldSelect', array('info' => array('name' => 'id_organization', 'sLabel' => '3', 'sField' => '4', 'data' => $organizations)))
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7', 'class' => '', 'required' => 'required')))
	@include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_metaData', 'sLabel' => '3', 'sField' => '4', 'data' => $metaDatas)))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_initialActivity', 'sLabel' => '3', 'sField' => '4', 'data' => $activities)))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_typesProcess', 'sLabel' => '3', 'sField' => '4', 'data' => $typesProcesses)))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2', 'data' => array('Yes' => 'Yes', 'No' => 'No'))))
	@include('elements.fieldText', array('info' => array('name' => 'startDate', 'sLabel' => '3', 'sField' => '2', 'class' => 'startDate')))
	@include('elements.fieldText', array('info' => array('name' => 'endDate', 'sLabel' => '3', 'sField' => '2', 'class' => 'endDate')))
	<div class="form-group col-12">
		<div class="col-offset-1 col-12">
			@include('elements.editButtonForm')
			@include('elements.deleteButtonForm')
			@include('elements.cancelButtonForm')
		</div>		
	</div>
	{{ Form::close() }}
@stop

@section('scripts')

@stop
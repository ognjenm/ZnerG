@extends('layouts.master')

@section('linkMenu')
	@include('elements.wfNewProcesses')
@stop

@section('content')
	<div class="title">
		<h4>{{ trans('ui.Register') . ' ' . ucfirst($modelName) }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::model($model, array('method' => 'PATCH', 'route' => array($modelName . '.update', $model->id), 'class' => 'form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{{ trans('ui.main') }}</a></li>
		<li><a href="#tab2" data-toggle="tab">{{ trans('ui.additional') }}</a></li>
		<li><a href="#tab3" data-toggle="tab">{{ trans('ui.history') }}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane fade in active" id="tab1">
			@if ($id_typesActivity == '1')
				@foreach($fields as $field)
					@if ($field->isDisabled == 'Yes' && $values[$field->id] == null)
						{{ Form::hidden($field->name, $values[$field->id], array('id' => $field->name, 'name' => $field->name)); }}
					@elseif ($field->isLinked == 'Yes')
						@if ($field->isFullSearch == 'Yes')
						    {{ Form::hidden($field->name, $values[$field->id], array('id' => $field->name, 'name' => $field->name)); }}
							@include('elements.fieldText', array('info' => array('name' => str_plural(substr($field->name, 3)), 'value' => $autocomplete[$field->id], 'data-field' => $field->name, 'data-relations' => $field->relations, 'class' => 'fulltextSearch', 'sLabel' => '3', 'sField' => '8', 'isCreatable' => $field->isCreatable, 'isEditable' => $field->isEditable, 'isDeletable' => $field->isDeletable, 'event' => 'onclick', 'function' => '', 'functionCreate' => 'return changeMethodToCreate(' . $field->id_structure . ',"' . str_plural(substr($field->name, 3)) . '", "edit");', 'functionEdit' => 'return changeMethodToEdit(' . $field->id_structure . ',' . $field->name . ', "edit");', 'functionDelete' => 'return changeMethodToDestroy(' . $field->id_structure . ',' . $field->name . ',' . $field->id . ', "edit");', 'disabled' => $field->isDisabled)))
						@else
							@if ($field->relations)
								@include('elements.fieldSelect', array('info' => array('name' => $field->name, 'value' => $values[$field->id], 'sLabel' => '3', 'sField' => '9', 'data' => $dd[$field->id], 'data-relations' => $field->relations, 'class' => 'ddRelated', 'isCreatable' => $field->isCreatable, 'isEditable' => $field->isEditable, 'isDeletable' => $field->isDeletable, 'event' => 'onclick', 'function' => 'changeMethodToCreate(' . $field->id_structure . ');', 'functionCreate' => 'changeMethodToCreate(' . $field->id_structure . ',' . $field->name . ', "edit");', 'functionEdit' => 'changeMethodToEdit(' . $field->id_structure . ',' . $field->name . ', "edit");', 'functionDelete' => 'changeMethodToDestroy(' . $field->id_structure . ',' . $field->name . ');', 'disabled' => $field->isDisabled)))
							@else
								@include('elements.fieldSelect', array('info' => array('name' => $field->name, 'sLabel' => '3', 'sField' => '9', 'data' => $dd[$field->id], 'value' => $values[$field->id], 'isCreatable' => $field->isCreatable, 'isEditable' => $field->isEditable, 'isDeletable' => $field->isDeletable, 'event' => 'onclick', 'function' => '', 'functionCreate' => 'return changeMethodToCreate(' . $field->id_structure . ',' . $field->name . ', "create");', 'functionEdit' => 'return changeMethodToEdit(' . $field->id_structure . ',' . $field->name . ', "create");', 'functionDelete' => 'return changeMethodToDestroy(' . $field->id_structure . ',' . $field->name . ',' . $field->id . ', "create");', 'disabled' => $field->isDisabled)))
							@endif
						@endif
					@else
						@if ($field->id_dataType  == 3 || $field->length > 32)
							@include('elements.fieldTextarea', array('info' => array('name' => $field->name, 'value' => $values[$field->id], 'sLabel' => '3', 'sField' => '9', 'disabled' => $field->isDisabled)))
						@elseif ($field->id_dataType == 15)
							@include('elements.fieldSelect', array('info' => array('name' => $field->name, 'value' => $values[$field->id], 'sLabel' => '3', 'sField' => '5', 'disabled' => $field->isDisabled)))
						@elseif ($field->id_dataType == 4)
							@include('elements.fieldText', array('info' => array('name' => $field->name, 'value' => $values[$field->id], 'sLabel' => '3', 'sField' => '5', 'class' => 'datePicker', 'disabled' => $field->isDisabled)))
						@elseif ($field->id_dataType == 12 || $field->id_dataType == 16)					
							@include('elements.fieldText', array('info' => array('name' => $field->name, 'value' => $values[$field->id], 'sLabel' => '3', 'sField' => '6', 'class' => 'datetimePicker', 'disabled' => $field->isDisabled)))
						@elseif ($field->id_dataType == 1 || $field->id_dataType == 7 || $field->id_dataType == 8 || $field->id_dataType == 9 || $field->id_dataType == 10)
							@include('elements.fieldText', array('info' => array('name' => $field->name, 'value' => $values[$field->id], 'sLabel' => '3', 'sField' => '5', 'disabled' => $field->isDisabled)))
						@elseif ($field->id_dataType == 5 || $field->id_dataType == 6 || $field->id_dataType == 13)
							@include('elements.fieldText', array('info' => array('name' => $field->name, 'value' => $values[$field->id], 'sLabel' => '3', 'sField' => '5', 'disabled' => $field->isDisabled)))
						@elseif ($field->id_dataType == 2)
							@include('elements.fieldText', array('info' => array('name' => $field->name, 'value' => $values[$field->id], 'sLabel' => '3', 'sField' => '9', 'disabled' => $field->isDisabled)))	
						@elseif ($field->id_dataType == 11)
							<p>Here the checkbox for boolean</p>
						@else
							<p>No definition for this dataType</p>
						@endif
					@endif
					@if ($field->name == 'id_eventNext')
						@include('elements.fieldText', array('info' => array('name' => 'dueDate', 'sLabel' => '3', 'sField' => '9', 'class' => 'datetimePicker')))
					@endif
				@endforeach
			@elseif ($id_typesActivity == '2')
				<p>Custom fields</p>
			@elseif ($id_typesActivity == '3')
				<p>External App</p>
				@if ($externalReference != '')
					@include('applications.' . $externalReference)
				@endif
			@endif
		</div>
		<div class="tab-pane fade" id="tab2">
			@include('elements.fieldText', array('info' => array('name' => 'expirationDate', 'value' => $expirationDate, 'sLabel' => '3', 'sField' => '9', 'class' => 'datetimePicker', 'disabled' => 'Yes')))
			@include('elements.fieldTextarea', array('info' => array('name' => 'notes', 'value' => $notes, 'sLabel' => '3', 'sField' => '9')))
		</div>
		<div class="tab-pane fade" id="tab3">
			Tasks executed with the instance in the past
		</div>
	</div>
	<nav class="navbar transparent navbar-inverse navbar-fixed-bottom" role="navigation">
		<div class="container">
			<div class="col-offset-2 col-8 text-center">
				@include('elements.saveButtonForm')
				@include('elements.customButton2Form', array('info' => array('name' => 'execute', 'class' => 'btn-success', 'event' => 'onclick', 'function' => 'changeMethodTo("execute")', 'data-method' => 'execute', 'data-confirm' => '', 'rel' => 'nofollow')))
				@include('elements.customButton2Form', array('info' => array('name' => 'terminate', 'class' => 'btn-warning', 'event' => 'onclick', 'function' => 'return changeMethodTo("terminate");', 'data-method' => 'terminate', 'data-confirm' => trans('ui.doYouWantToTerminate'), 'rel' => 'nofollow')))
				@include('elements.cancelButtonForm')
			</div>
		</div>
<!-- 	  <div class="container">
	    ...
	  </div> -->
	</nav>

	{{ Form::hidden('lat', null, array('class' => 'form-control', 'id' => 'lat')) }}
	{{ Form::hidden('lon', null, array('class' => 'form-control', 'id' => 'lon')) }}
    {{ Form::hidden('id_activitiesProcess', $id_activitiesProcess); }}
    {{ Form::hidden('id_employee', $id_employee); }}
    {{ Form::hidden('id_metaData', $id_metaData); }}
    {{ Form::hidden('id_typesActivity', $id_typesActivity); }}
    {{ Form::hidden('tableName', $tableName); }}
    {{ Form::hidden('id', $id); }}
    {{ Form::hidden('_minCharactersAutocomplete', $_minCharactersAutocomplete, array('id' => '_minCharactersAutocomplete')); }}
	{{ Form::close() }}
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
	{{ HTML::script('js/bootstrap-datepicker.js') }}
	<!-- {{ HTML::script('js/bootstrap-datetimepicker.min.js') }} -->
	{{ HTML::script('js/jquery.datetimepicker.js') }}
	{{ HTML::script('js/jquery-ui-1.10.3.custom.js') }}
	<script>
		$('#dueDate').datetimepicker({
		  format:'Y-m-d H:i:s',
		  minDate: 0,
 		  allowTimes:['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', 
 					 '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00'],
		  step: 30,
		  lang:'en',
		  allowBlank:true
		});

		// $('.datetimePicker').datetimepicker({
		//   });

		$('.datePicker').datepicker({
		  dateFormat: 'yy-mm-dd'
		  });

		if (top.location != location) {
	    	top.location.href = document.location.href;
	  	}
	</script>
	{{ HTML::script('js/instance.js')}}
	{{ HTML::script('js/geolocation.js')}}
@stop
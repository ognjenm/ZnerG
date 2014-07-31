@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::model($model, array('method' => 'PATCH', 'route' => array($modelName . '.update', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@if (Auth::user()->id_organization == 1)
		@include('elements.fieldSelectActive', array('info' => array('name' => 'id_organization', 'sLabel' => '3', 'sField' => '4', 'disabled' => 'Yes', 'data' => $organizations, 'value' => $id_organization)))
    @else
    	{{ Form::hidden('id_organization', Auth::user()->id_organization); }}
    @endif
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7', 'class' => '', 'required' => 'required')))
	@include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_metaData', 'sLabel' => '3', 'sField' => '4', 'data' => $metaDatas)))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_initialActivity', 'sLabel' => '3', 'sField' => '4', 'data' => $activities)))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_typesProcess', 'sLabel' => '3', 'sField' => '4', 'data' => $typesProcesses)))
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2', 'data' => array('Yes' => 'Yes', 'No' => 'No'))))
	@include('elements.fieldText', array('info' => array('name' => 'startDate', 'sLabel' => '3', 'sField' => '2', 'class' => 'datePicker')))
	@include('elements.fieldText', array('info' => array('name' => 'endDate', 'sLabel' => '3', 'sField' => '2', 'class' => 'datePicker')))
	<div class="form-group col-12">
		<div class="col-offset-1 col-12">
			@include('elements.updateButtonForm')
			@include('elements.deleteButtonForm')
			<button class="btn btn-primary sameSizeButton" data-toggle="modal" data-target="#activitiesModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.activities') }}</button>
			@include('elements.cancelButtonForm')
		</div>		
	</div>
	{{ Form::close() }}
	<div class="modal fade" id="activitiesModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" tabindex="1">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">{{ trans('ui.assignActivities') }}</h4>
	      		</div>
		      	<div class="modal-body">
					{{ Form::open(array('url' => array($modelName . '/assignActivities'),
									 'method' => 'GET',
									 'class' => 'form-horizontal form-standard',
									 'id' => 'listActivities', 'name' => 'list')) }}
					<table class="table table-condensed table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="width: 60%">{{ trans('ui.name') }}</th>
								<th style="width: 35%">{{ trans('ui.externalReference') }}</th>
								<th style="width: 5%"></th>
							</tr>
						</thead>
						@if (count($listActivities))
						<tbody>		
							@foreach($listActivities as $record)
								<tr>
									<td>{{ $record->name }}</td>
									<td>{{ $record->externalReference }}</td>
									<td class="text-center">
										@if ($record->checked)
											{{ Form::checkbox('records[]', $record->id, true, array('id' => $record->id)) }}
										@else
											{{ Form::checkbox('records[]', $record->id, false, array('id' => $record->id)) }}
										@endif
									</td>
								</tr>			
							@endforeach
						</tbody>
						@endif
					</table>
				</div>
		      	<div class="modal-footer">
		      		@include('elements.updateButtonModal')
		      		@include('elements.cancelButtonModal')
	      		</div>
	      		{{ Form::hidden('id', $model->id) }}
	 			{{ Form::close() }}
	    	</div>
		</div>
	</div>	
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
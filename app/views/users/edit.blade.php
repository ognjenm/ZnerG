@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::model($model, array('method' => 'PATCH', 'route' => array($modelName . '.update', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('name' => 'username', 'sLabel' => '3', 'sField' => '7', 'disabled' => 'Yes')))
	@if (Auth::user()->id_organization == 1)
		@include('elements.fieldSelect', array('info' => array('name' => 'id_organization', 'sLabel' => '3', 'sField' => '4', 'disabled' => 'Yes', 'data' => $organizations)))
    @else
    	{{ Form::hidden('id_organization', Auth::user()->id_organization); }}
    @endif
	@include('elements.fieldSelect', array('info' => array('name' => 'id_employee', 'sLabel' => '3', 'sField' => '4', 'data' => $employees)))
	@include('elements.fieldText', array('info' => array('name' => 'email', 'sLabel' => '3', 'sField' => '7')))
	@include('elements.fieldSelect', array('info' => array('name' => 'id_recoveryQuestion', 'sLabel' => '3', 'sField' => '7', 'data' => $recoveryQuestions)))
	@include('elements.fieldText', array('info' => array('name' => 'answer', 'sLabel' => '3', 'sField' => '4')))
	@include('elements.fieldText', array('info' => array('name' => 'alternativeId', 'sLabel' => '3', 'sField' => '3')))
	@if ($model->isSystem == 'No' || $model->id != Auth::user()->id)
		@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
		@include('elements.fieldSelect', array('info' => array('name' => 'isSystem', 'sLabel' => '3', 'sField' => '2')))
	@endif
	<div class="form-group col-12">
		<div class="col-offset-1 col-12">
			@include('elements.updateButtonForm')
			@include('elements.deleteButtonForm')
			<button class="btn btn-primary sameSizeButton" data-toggle="modal" data-target="#rolesModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.roles') }}</button>
			<button class="btn btn-primary sameSizeButton" data-toggle="modal" data-target="#groupsModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.groups') }}</button>
			<button class="btn btn-primary" data-toggle="modal" data-target="#passwordModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.changePassword') }}</button>
			@include('elements.cancelButtonForm')
		</div>		
	</div>
	{{ Form::hidden('id', $model->id, array('id' => 'id')); }}
	{{ Form::close() }}

	<div class="modal" id="rolesModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" tabindex="1">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">{{ trans('ui.assignRoles') }}</h4>
	      		</div>
		      	<div class="modal-body">
					{{ Form::open(array('url' => array($modelName . '/assignRoles'),
									 'method' => 'GET',
									 'class' => 'form-horizontal form-standard',
									 'id' => 'listRoles', 'name' => 'list')) }}
					@include('elements.messagesModal')
					<table class="table table-condensed table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="width: 55%">{{ trans('ui.name') }}</th>
								<th style="width: 20%">{{ trans('ui.startDate') }}</th>
								<th style="width: 20%">{{ trans('ui.endDate') }}</th>
								<th style="width: 5%"></th>
							</tr>
						</thead>
						@if (count($listRoles))
						<tbody>		
							@foreach($listRoles as $key => $record)				
								<tr>
									<td>{{ $record->name }}</td>
									<td class="text-center">
										{{ Form::text('startDate' . $record->id, $record->startDate, array('class' => 'form-control startDate')) }}
									</td>
									<td class="text-center">
										{{ Form::text('endDate' . $record->id, $record->endDate, array('class' => 'form-control endDate')) }}
									</td>
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
	      		{{ Form::hidden('id', $model->id); }}
				{{ Form::hidden('activateRolesModal', $activateRolesModal, array('id' => 'activateRolesModal')); }}
				{{ Form::close() }}
	    	</div>
		</div>
	</div>

	<div class="modal fade" id="groupsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">{{ trans('ui.assignGroups') }}</h4>
	      		</div>
		      	<div class="modal-body">
					{{ Form::open(array('url' => array($modelName . '/assignGroups'),
									 'method' => 'GET',
									 'class' => 'form-horizontal form-standard',
									 'id' => 'listGroups', 'name' => 'list')) }}
					<table class="table table-condensed table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="width: 95%">{{ trans('ui.name') }}</th>
								<th style="width: 5%"></th>
							</tr>
						</thead>
						@if (count($listGroups))
						<tbody>		
							@foreach($listGroups as $record)				
								<tr>
									<td>{{ $record->name }}</td>
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
	      		{{ Form::hidden('id', $model->id); }}
				{{ Form::close() }}
	    	</div>
		</div>
	</div>

	<div class="modal" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" tabindex="1">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">{{ trans('ui.changePassword') }}</h4>
	      		</div>
				{{ Form::open(array('url' => array($modelName . '/changePassword'),
								 'method' => 'GET',
								 'class' => 'form-horizontal',
								 'id' => 'changePasswordForm', 'name' => 'changePasswordForm')) }}
		      	<div class="modal-body">
					<div class="well">
						@include('elements.messagesModal')
						<div class="form-group">
							{{ Form::label('password', trans('ui.password') . ':', array('class' => 'col-4 required')) }}
							<div class="col-6">
								{{ Form::password('password', null, array('class' => 'form-control')) }}
							</div>		
						</div>
						<div class="form-group">
							{{ Form::label('password_confirmation', trans('ui.passwordConfirmation') . ':', array('class' => 'col-4 required')) }}
							<div class="col-6">
								{{ Form::password('password_confirmation', null, array('class' => 'form-control')) }}
							</div>		
						</div>
					</div>
				</div>
		      	<div class="modal-footer">
		      		@include('elements.updateButtonModal')
		      		@include('elements.cancelButtonModal')
	      		</div>
	      		{{ Form::hidden('id', $model->id, array('id' => 'id')); }}
				{{ Form::hidden('activatePasswordModal', $activatePasswordModal, array('id' => 'activatePasswordModal')); }}
				{{ Form::close() }}
	    	</div>
		</div>
	</div>
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
	{{ HTML::script('js/bootstrap-datepicker.js')}}
	<script type="text/javascript">
		if (top.location != location) {
	    	top.location.href = document.location.href;
	  	}
	</script>
@stop
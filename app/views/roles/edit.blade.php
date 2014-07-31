@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::model($model, array('method' => 'PATCH', 'route' => array($modelName . '.update', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
	@if (Auth::user()->id_organization == 1)
		@include('elements.fieldSelect', array('info' => array('name' => 'id_organization', 'sLabel' => '3', 'sField' => '4', 'data' => $organizations)))
    @else
    	{{ Form::hidden('id_organization', Auth::user()->id_organization); }}
    @endif
    @include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
	@if ($model->isSystem == 'No' || $model->id != Auth::user()->id)
		@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
		@include('elements.fieldSelect', array('info' => array('name' => 'isSystem', 'sLabel' => '3', 'sField' => '2')))
	@endif
	<div class="form-group col-12">
		<div class="col-offset-1 col-12">
			@include('elements.updateButtonForm')
			@include('elements.deleteButtonForm')
			<button class="btn btn-primary" data-toggle="modal" data-target="#optionsModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.menuOptions') }}</button>
			<button class="btn btn-primary sameSizeButton" data-toggle="modal" data-target="#groupsModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.groups') }}</button>
			<button class="btn btn-primary sameSizeButton" data-toggle="modal" data-target="#usersModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.users') }}</button>
			@include('elements.cancelButtonForm')
		</div>		
	</div>
	{{ Form::close() }}

	<div class="modal fade" id="optionsModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" tabindex="1">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">{{ trans('ui.assignOptions') }}</h4>
	      		</div>
		      	<div class="modal-body">
					{{ Form::open(array('url' => array($modelName . '/assignOptions'),
									 'method' => 'GET',
									 'class' => 'form-horizontal form-standard',
									 'id' => 'listOptions', 'name' => 'list')) }}
					<table class="table table-condensed table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="width: 40%">{{ trans('ui.name') }}</th>
								<th style="width: 15%">{{ trans('ui.execute') }}</th>
								<th style="width: 15%">{{ trans('ui.insert') }}</th>
								<th style="width: 15%">{{ trans('ui.update') }}</th>
								<th style="width: 15%">{{ trans('ui.delete') }}</th>
							</tr>
						</thead>
						@if (count($listOptions))
						<tbody>		
							@foreach($listOptions as $record)
								<tr>
									<td>{{ $record->name }}</td>
									<td class="text-center">
										@if ($record->authExecute)
											{{ Form::checkbox('records[]', 'execut' . $record->id, true, array('id' => 'execut' . $record->id)) }}
										@else
											{{ Form::checkbox('records[]', 'execut' . $record->id, false, array('id' => 'execut' . $record->id)) }}
										@endif
									</td>
									<td class="text-center">
										@if ($record->authInsert)
											{{ Form::checkbox('records[]', 'insert' . $record->id, true, array('id' => 'insert' . $record->id)) }}
										@else
											{{ Form::checkbox('records[]', 'insert' . $record->id, false, array('id' => 'insert' . $record->id)) }}
										@endif
									</td>
									<td class="text-center">
										@if ($record->authUpdate)
											{{ Form::checkbox('records[]', 'update' . $record->id, true, array('id' => 'update' . $record->id)) }}
										@else
											{{ Form::checkbox('records[]', 'update' . $record->id, false, array('id' => 'update' . $record->id)) }}
										@endif
									</td>
									<td class="text-center">
										@if ($record->authDelete)
											{{ Form::checkbox('records[]', 'delete' . $record->id, true, array('id' => 'delete' . $record->id)) }}
										@else
											{{ Form::checkbox('records[]', 'delete' . $record->id, false, array('id' => 'delete' . $record->id)) }}
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

	<div class="modal fade" id="groupsModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" tabindex="1">
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
	      		{{ Form::hidden('id', $model->id) }}
	 			{{ Form::close() }}
	    	</div>
		</div>
	</div>

	<div class="modal" id="usersModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" tabindex="1">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">{{ trans('ui.assignUsers') }}</h4>
	      		</div>
		      	<div class="modal-body">
					{{ Form::open(array('url' => array($modelName . '/assignUsers'),
									 'method' => 'GET',
									 'class' => 'form-horizontal form-standard',
									 'id' => 'listUsers', 'name' => 'list')) }}
					@include('elements.messagesModal')
					<table class="table table-condensed table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="width: 30%">{{ trans('ui.username') }}</th>
								<th style="width: 25%">{{ trans('ui.employeeName') }}</th>
								<th style="width: 20%">{{ trans('ui.startDate') }}</th>
								<th style="width: 20%">{{ trans('ui.endDate') }}</th>
								<th style="width: 5%"></th>
							</tr>
						</thead>
						@if (count($listUsers))
						<tbody>		
							@foreach($listUsers as $key => $record)				
								<tr>
									<td>{{ $record->username }}</td>
									<td>{{ $record->firstName . ' ' . $record->lastName}}</td>
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
	      		{{ Form::hidden('id', $model->id) }}
				{{ Form::hidden('activateUsersModal', $activateUsersModal, array('id' => 'activateUsersModal')) }}
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
		$(function(){
			window.prettyPrint && prettyPrint();
			$('.startDate').datepicker({
				format: 'yyyy-mm-dd'
			});
			$('.endDate').datepicker({
				format: 'yyyy-mm-dd'
			});
		});
	</script>
@stop
@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::model($model, array('method' => 'PATCH', 'route' => array($modelName . '.update', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}

	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
	@if (Auth::user()->id_organization == 1)
	@include('elements.fieldSelect', array('info' => array('name' => 'id_organization', 'sLabel' => '3', 'sField' => '4', 'disabled' => 'Yes', 'data' => $organizations)))
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
			<button class="btn btn-primary sameSizeButton" data-toggle="modal" data-target="#rolesModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.roles') }}</button>
			<button class="btn btn-primary sameSizeButton" data-toggle="modal" data-target="#usersModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.users') }}</button>
			@include('elements.cancelButtonForm')
		</div>		
	</div>
	{{ Form::close() }}

	<div class="modal fade" id="rolesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
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
					<table class="table table-condensed table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="width: 95%">{{ trans('ui.name') }}</th>
								<th style="width: 5%"></th>
							</tr>
						</thead>
						@if (count($listRoles))
						<tbody>		
							@foreach($listRoles as $record)				
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

	<div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
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
					<table class="table table-condensed table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="width: 50%">{{ trans('ui.username') }}</th>
								<th style="width: 45%">{{ trans('ui.employeeName') }}</th>
								<th style="width: 5%"></th>
							</tr>
						</thead>
						@if (count($listUsers))
						<tbody>		
							@foreach($listUsers as $record)				
								<tr>
									<td>{{ $record->username }}</td>
									<td>{{ $record->fullName }}</td>
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
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop
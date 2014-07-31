@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ ucfirst($metaDataName) . ': ' . trans('ui.editing') . ' ' . ucfirst($modelName) }}</h4>
	</div>
	@include('elements.messages')
	{{ Form::open(array('url' => array($modelName . '/' . $id_field . '/edit'),
					 'method' => 'GET',
					 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm',
					 'id' => 'filterForm', 'name' => 'filterForm')) }}
		@include('elements.fieldSelectActive', array('info' => array('name' => 'id_typesApplication', 'sLabel' => '3', 'sField' => '3', 'data' => $typesApplications, 'value' => $filter, 'event' => 'onchange', 'function' => 'ddFilter();')))
	{{ Form::hidden('id', $id_field) }}
	{{ Form::close() }}

	{{ Form::model($model, array('method' => 'PATCH', 'route' => array($modelName . '.update', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
	@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
    @include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
    @if ($typesApplicationName == 'External')
		@include('elements.fieldText', array('info' => array('name' => 'externalReference', 'sLabel' => '3', 'sField' => '7')))
	@endif
	@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '2')))
	<div class="form-group col-12">
		<div class="col-offset-1 col-12">
			@include('elements.updateButtonForm')
		    @if ($typesApplicationName == 'Custom')
				<button class="btn btn-primary sameSizeButton" data-toggle="modal" data-target="#fieldsModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.fields') }}</button>
			@endif
			@include('elements.deleteButtonForm')
			@include('elements.cancelButtonForm')
		</div>		
	</div>
    {{ Form::hidden('id_metaData', $id_metaData); }}
  	{{ Form::hidden('id_typesApplication', $filter); }}
	{{ Form::close() }}

	<div class="modal fade" id="fieldsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">{{ trans('ui.assignFields') }}</h4>
	      		</div>
		      	<div class="modal-body">
					{{ Form::open(array('url' => array($modelName . '/assignFields'),
									 'method' => 'GET',
									 'class' => 'form-horizontal form-standard',
									 'id' => 'listFields', 'name' => 'list')) }}
					<table class="table table-condensed table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="width: 5%">{{ trans('ui.isV') }}</th>
								<th style="width: 10%">{{ trans('ui.pos') }}</th>
								<th style="width: 15%">{{ trans('ui.name') }}</th>
								<th style="width: 15%">{{ trans('ui.label') }}</th>
								<th style="width: 30%">{{ trans('ui.description') }}</th>
								<th style="width: 10%">{{ trans('ui.size') }}</th>
								<th style="width: 5%">{{ trans('ui.isE') }}</th>
								<th style="width: 5%">{{ trans('ui.isC') }}</th>
								<th style="width: 5%">{{ trans('ui.isD') }}</th>
							</tr>
						</thead>
						@if (count($listFields))
						<tbody>		
							@foreach($listFields as $record)				
								<tr>
									<td class="text-center">
										@if ($record->checked)
											{{ Form::checkbox('records[]', $record->id, true, array('id' => $record->id)) }}
										@else
											{{ Form::checkbox('records[]', $record->id, false, array('id' => $record->id)) }}
										@endif
									</td>
									<td></td>
									<td>{{ $record->name }}</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
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
@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.all' . ucfirst($modelName)) }}</h4>
	@include('elements.submenuFilters')
	<table class="table table-condensed table-striped table-bordered table-hover">
		<thead>
			<tr>
				@if ($id_filterValues['id_organization'] == 0 && Auth::user()->id == 1)
					<th style="width: 25%">{{ trans('ui.username') }}</th>
					<th style="width: 25%">{{ trans('ui.organization') }}</th>
				@else
					<th style="width: 25%">{{ trans('ui.username') }}</th>
					<th style="width: 25%">{{ trans('ui.email') }}</th>
				@endif
				<th style="width: 20%">{{ trans('ui.employeeName') }}</th>
				<th style="width: 10%">{{ trans('ui.alternativeId') }}</th>
				<th colspan="2" style="width: 20%">{{ trans('ui.actions') }}</th>
			</tr>
		</thead>
		@if ($modelData->count())
		<tbody>		
			@foreach($modelData as $record)				
				@if ($record->isActive == 'No')
					@if ($record->isSystem == 'Yes')
						<tr class="warning text-muted">
					@else
						<tr class="warning">
					@endif						
				@else
					@if ($record->isSystem == 'Yes')
						<tr class="text-muted">
					@else
						<tr>
					@endif
				@endif
					@if ($id_filterValues['id_organization'] == 0 && Auth::user()->id == 1)
						<td>
							@include('elements.linkTable', array('info' => array('name' => $record->username)))
						</td>
						<td>{{ $record->organization->name }}</td>
					@else
						<td>
							@include('elements.linkTable', array('info' => array('name' => $record->username)))
						</td>
						<td>{{ $record->email }}</td>
					@endif
					@if ($record->employee)
						<td>{{ $record->employee->full_name }}</td>
					@else
						<td></td>
					@endif
					<td>{{ $record->alternativeId }}</td>
					<td class="text-center">
						@include('elements.editButtonTable')
					</td>
					<td class="text-center">
						@include('elements.deleteButtonTable')
					</td>
				</tr>			
			@endforeach
		</tbody>
		@endif
	</table>
	@include('elements.footTable', array('info' => array('data' => $modelData)))
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop

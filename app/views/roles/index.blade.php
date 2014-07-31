@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.all' . ucfirst($modelName)) }}</h4>
	@include('elements.submenuFilters')
	<table class="table table-condensed table-striped table-bordered table-hover">
		<thead>
			<tr>
				@if ($id_filterValues['id_organization'] == 0 && Auth::user()->id == 1)
					<th style="width: 25%">{{ trans('ui.name') }}</th>
					<th style="width: 25%">{{ trans('ui.organization') }}</th>
				@else
					<th style="width: 50%">{{ trans('ui.name') }}</th>
				@endif
				<th style="width: 15%">{{ trans('ui.isActive') }}</th>
				<th style="width: 15%">{{ trans('ui.isSystem') }}</th>
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
							@include('elements.linkTable', array('info' => array('name' => $record->name, 'popover' => $record->description)))
						</td>
						<td>{{ $record->organization->name }}</td>
					@else
						<td>
							@include('elements.linkTable', array('info' => array('name' => $record->name, 'popover' => $record->description)))
						</td>
					@endif
					<td class="text-center">{{ $record->isActive }}</td>
					<td class="text-center">{{ $record->isSystem }}</td>
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

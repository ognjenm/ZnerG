@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.all' . ucfirst($modelName)) }}</h4>
	@include('elements.submenu')
	<table class="table table-condensed table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th style="width: 40%">{{ trans('ui.name') }}</th>
				<th style="width: 10%">{{ trans('ui.isActive') }}</th>
				<th style="width: 15%">{{ trans('ui.startDate') }}</th>
				<th style="width: 15%">{{ trans('ui.endDate') }}</th>
				<th colspan="2">{{ trans('ui.actions') }}</th>
			</tr>
		</thead>
		@if ($modelData->count())
		<tbody>		
			@foreach($modelData as $record)				
			<tr {{ $record->isActive == 'No' ? 'class="warning"' : ''}}>
				<td>
					@include('elements.linkTable', array('info' => array('name' => $record->name)))
				</td>
				<td class="text-center">{{ $record->isActive }}</td>
				<td class="text-center">{{ $record->startDate }}</td>
				<td class="text-center">{{ $record->endDate }}</td>
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
	@include('elements.footTable')
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop

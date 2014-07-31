@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.all' . ucfirst($modelName)) }}</h4>
	@include('elements.submenuMetaData')
	<table class="table table-condensed table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th style="width: 30%">{{ trans('ui.name') }}</th>
				<th style="width: 10%">{{ trans('ui.isLinked') }}</th>
				<th style="width: 10%">{{ trans('ui.positionUI') }}</th>
				<th style="width: 10%">{{ trans('ui.isVisible') }}</th>
				<th style="width: 10%">{{ trans('ui.isDisabled') }}</th>
				<th style="width: 10%">{{ trans('ui.isActive') }}</th>
				<th colspan="2">{{ trans('ui.actions') }}</th>
			</tr>
		</thead>
		@if ($modelData->count())
		<tbody>		
			@foreach($modelData as $record)				
				<tr {{ $record->isActive == 'No' ? 'class="warning"' : ''}}>
					<td>
						@include('elements.linkTable', array('info' => array('name' => $record->name, 'popover' => $record->description)))
					</td>
					<td>{{ $record->isLinked }}</td>
					<td>{{ $record->positionUI }}</td>
					<td>{{ $record->isVisible }}</td>
					<td>{{ $record->isDisabled }}</td>
					<td>{{ $record->isActive }}</td>
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

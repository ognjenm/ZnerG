@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.all' . ucfirst($modelName)) }}</h4>
	@include('elements.submenu')
	<table class="table table-condensed table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th style="width: 25%">{{ trans('ui.name') }}</th>
				<th style="width: 25%">{{ trans('ui.value') }}</th>
				<th style="width: 15%">{{ trans('ui.access') }}</th>
				<th style="width: 15%">{{ trans('ui.category') }}</th>
				<th style="width: 20%" colspan="2">{{ trans('ui.actions') }}</th>
			</tr>
		</thead>
		@if ($modelData->count())
		<tbody>		
			@foreach($modelData as $record)		
			<tr>					
				<td>
					@include('elements.linkTable', array('info' => array('name' => $record->name, 'popover' => $record->description)))
				</td>
				<td class="text-center">{{ $record->value }}</td>
				<td class="text-center">{{ $record->access }}</td>
				<td class="text-center">{{ $record->category }}</td>
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

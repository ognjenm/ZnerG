@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.all' . ucfirst($modelName)) }}</h4>
	@include('elements.submenu')
	<table class="table table-condensed table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th style="width: 30%">{{ trans('ui.name') }}</th>
				<th style="width: 30%">{{ trans('ui.shortName') }}</th>
				<th style="width: 20%">{{ trans('ui.isActive') }}</th>
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
					<td>{{$record->shortName}}</td>
					<td class="text-center">{{ $record->isActive }}</td>
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

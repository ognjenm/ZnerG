@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.all' . ucfirst($modelName)) }}</h4>
	@include('elements.submenuFilters')
	<table class="table table-condensed table-striped table-bordered table-hover">
		<thead>
			<tr>
				@if ($id_filterValues['id_database'] == 0  && Auth::user()->id == 1)
					<th style="width: 30%">{{ trans('ui.addressLine1') }}</th>
					<th style="width: 20%">{{ trans('ui.database') }}</th>
				@else
					<th style="width: 50%">{{ trans('ui.addressLine1') }}</th>
				@endif
				<th style="width: 20%">{{ trans('ui.city') }}</th>
				<th style="width: 10%">{{ trans('ui.zipcode') }}</th>
				<th colspan="2">{{ trans('ui.actions') }}</th>
			</tr>
		</thead>
		@if ($modelData->count())
			<tbody>		
				@foreach($modelData as $record)
				<tr {{ $record->isActive == 'No' ? 'class="warning"' : ''}}>
					@if ($id_filterValues['id_database'] == 0 && Auth::user()->id == 1)
						<td>
							@include('elements.linkTable', array('info' => array('name' => $record->addressLine1, 'popover' => $record->reference)))
						</td>
						<td>{{ $record->database->name }}</td>
					@else
						<td>
							@include('elements.linkTable', array('info' => array('name' => $record->addressLine1, 'popover' => $record->reference)))
						</td>
					@endif
					<td class="text-center">{{ $record->city->name }}</td>
					<td class="text-center">{{ $record->zipcode }}</td>
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

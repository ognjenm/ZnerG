@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.all' . ucfirst($modelName)) }}</h4>
	@include('elements.submenuOrganization')
	<table class="table table-condensed table-striped table-bordered table-hover">
		<thead>
			<tr>
				@if ($id_organization == 0)
					<th style="width: 30%">{{ trans('ui.name') }}</th>
					<th style="width: 30%">{{ trans('ui.organization') }}</th>
				@else
					<th style="width: 60%">{{ trans('ui.name') }}</th>
				@endif
				<th style="width: 20%">{{ trans('ui.isActive') }}</th>
				<th colspan="2">{{ trans('ui.actions') }}</th>
			</tr>
		</thead>
		@if ($modelData->count())
		<tbody>		
			@foreach($modelData as $record)	
				<tr {{ $record->isActive == 'No' ? 'class="warning"' : ''}}>
					@if ($id_organization == 0)
						<td>
							@include('elements.linkTable', array('info' => array('name' => $record->name, 'popover' => $record->description)))
						</td>
						<td>{{$record->organization->name}}</td>
					@else
						<td>
							@include('elements.linkTable', array('info' => array('name' => $record->name, 'popover' => $record->description)))
						</td>
					@endif
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
	@include('elements.footTable')
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop

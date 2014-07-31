@extends('layouts.master')

@section('content')
	@include('elements.searchBox')
		{{ Form::open(array('url' => array($modelName . '/save'),
					 'method' => 'GET',
					 'class' => 'form-horizontal form-standard',
					 'id' => 'modelData', 'name' => 'list')) }}

		<table class="table table-condensed table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th style="width: 95%">{{ trans('ui.name') }}</th>
					<th style="width: 5%"></th>
				</tr>
			</thead>
			@if (count($modelData))
			<tbody>		
				@foreach($modelData as $record)				
					<tr>
						<td>{{ $record->name }}</td>
						<td class="text-center">
							@if ($record->isVisible)
								{{ Form::hidden('records[]', $record->id, false, array('id' => $record->id)) }}
								{{ Form::checkbox('records[]', 'Y' . $record->id, true, array('id' => 'Y' . $record->id)) }}
							@else
								{{ Form::hidden('records[]', $record->id, false, array('id' => $record->id)) }}
								{{ Form::checkbox('records[]', 'Y' . $record->id, false, array('id' => 'Y' . $record->id)) }}
							@endif
						</td>
					</tr>			
				@endforeach
			</tbody>
			@endif
		</table>
	@include('elements.footTable', array('info' => array('data' => $modelData)))
  	<div class="text-center">
			@include('elements.updateButtonForm')
			@include('elements.cancelButtonForm')
	</div>
	{{ Form::close() }}
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop



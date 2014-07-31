@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.MyProduction') }}</h4>
	<table class="table table-condensed table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th style="width: 20%">{{ trans('ui.Date') }}</th>
				<th style="width: 10%">{{ trans('ui.TD') }}</th>
				<th style="width: 10%">{{ trans('ui.HM') }}</th>
				<th style="width: 10%">{{ trans('ui.QD') }}</th>
				<th style="width: 10%">{{ trans('ui.DM') }}</th>
				<th style="width: 20%">{{ trans('ui.Sales') }}</th>
				<th style="width: 20%">{{ trans('ui.AR') }}</th>
			</tr>
		</thead>
		@if (count($modelData))
			<tbody>
				@foreach($modelData as $record)		
				<tr>
					<td class="text-center">{{ $record->Date }}</td>
					<td class="text-center">{{ $record->TD }}</td>
					<td class="text-center">{{ $record->HM }}</td>
					<td class="text-center">{{ $record->QD }}</td>
					<td class="text-center">{{ $record->DM }}</td>
					<td class="text-center">{{ $record->Sales }}</td>
					<td class="text-center"></td>
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

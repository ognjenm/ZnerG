@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.all' . ucfirst($modelName)) }}</h4>
	<div id="map-canvas" class="map-canvas"></div>
	{{ Form::open(array('url' => array($modelName . '/search'),
					 'method' => 'GET',
					 'class' => 'navbar-form navbar-left form-horizontal form-standard subMenu',
					 'id' => 'searchForm', 'name' => 'searchForm')) }}
		<li>
			<div class="searchBox input-group input-group-xs col-8">
				{{ Form::text('lat', $lat, array('class' => 'form-control', 'id' => 'lat')) }}
				{{ Form::text('lon', $lon, array('class' => 'form-control', 'id' => 'lon')) }}
				<span class="input-group-btn">
					{{ Form::submit(trans('ui.search'), array('class' => 'btn btn-default btn-sm')) }}
				</span>
			</div>
		</li>				
	{{ Form::close() }}
	@if (isset($error))
	<p>{{ $error }}</p>
	@else	
	<p>{{ var_dump($geocode) }}</p>
	@endif

@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop



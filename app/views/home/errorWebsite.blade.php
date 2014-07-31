@extends('layouts.website')

@section('menu')
	@include('elements.menu')
@stop

@section('content')
	<h4>{{ trans('ui.noneExistantPage') }}
	@if (Auth::check())
		{{  link_to_action('HomeController@getMain', trans('ui.here')) }}
	@else
		{{  link_to_action('HomeController@getIndex', trans('ui.here')) }}
	@endif
	{{ trans('ui.goBackToMainPage') }}</h4>
@stop

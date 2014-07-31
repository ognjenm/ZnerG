@extends('layouts.master')

@section('content')
	@if (isset($error))
		<h4>{{ $error . '. '}}
		{{ trans('ui.click') . ' ' }}
		{{ link_to_action('HomeController@getMain', trans('ui.here')) }}
	@else
		<h4>{{ trans('ui.noneExistantPage') }}
		@if (Auth::check())
			{{  link_to_action('HomeController@getMain', trans('ui.here')) }}
		@else
			{{  link_to_action('HomeController@getIndex', trans('ui.here')) }}
		@endif
	@endif
	{{ trans('ui.goBackToMainPage') }}</h4>
@stop

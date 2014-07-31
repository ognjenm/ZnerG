@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.all' . ucfirst($modelName)) }}</h4>
	@include('elements.searchBox')
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop



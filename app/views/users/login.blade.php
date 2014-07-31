@extends('layouts.clean')

@section('content')
	<br>
	<br>
	<br>
	<div class="col-xs-12 well login">
		<div class="header row col-xs-12">
			<div class="header col-xs-7">
				<h4 class="title text-left">{{ trans('ui.pleaseLogin') }}</h4>
			</div>
			<div class="header col-xs-5">
				<h4 class="title text-right"><b>{{ Session::get('shortName') }}</b></h4>
			</div>
		</div>
		<hr/>
		{{ Form::open(array('url' => 'login', 'class' => 'form-standard')) }}
		@include('elements.messages')
		{{ Form::text('username', null, array('placeholder' => trans('ui.username'), 'class' => 'form-control')) }}<br>
		{{ Form::password('password', array('placeholder' => trans('ui.password'), 'class' => 'form-control')) }}<br>
		<div class="text-center">
			{{ HTML::link('password/reset', trans('ui.forgotPassword')) }}
		</div>
		<br>
		<div class="text-center">
			{{ Form::submit(trans('ui.login'), array('class' => 'btn btn-default btn-success sameSizeButton')) }}
			{{ HTML::link('register', trans('ui.register'), array('class' => 'btn btn-default btn-primary sameSizeButton')) }}
		</div>
		{{ Form::close() }}
	</div>
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop
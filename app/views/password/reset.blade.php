@extends('layouts.clean')

@section('content')

<div class="col-12">
	<br>
	<br>
	<br>
	<div class="col-6 col-offset-3 well">
		<h4 class="title">{{ trans('ui.forgotPassword') }}</h4>
		<hr/>
		@if (Session::has('error'))
		<div class="alert alert-danger small">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			{{ trans(Session::get('reason')) }}
		</div>
		@endif
		@include('elements.messages')
		{{ Form::open(array('url' => array('password/reset', $token), 'class' => 'form-horizontal form-standard')) }}

		<div class="form-group">
			{{ Form::label('email', trans('ui.email') . ':', array('class' => 'col-5')) }}
			<div class="col-7">
				{{ Form::text('email', null, array('class' => 'form-control')) }}
			</div>		
		</div>

		<div class="form-group">
			{{ Form::label('password', trans('ui.password') . ':', array('class' => 'col-5')) }}
			<div class="col-7">
				{{ Form::password('password', null, array('class' => 'form-control')) }}
			</div>		
		</div>
		<div class="form-group">
			{{ Form::label('password_confirmation', trans('ui.passwordConfirmation') . ':', array('class' => 'col-5')) }}
			<div class="col-7">
				{{ Form::password('password_confirmation', null, array('class' => 'form-control')) }}
			</div>		
		</div>
		{{ Form::hidden('token', $token) }}
		<div class="text-center">
			{{ Form::submit(trans('ui.submit'), array('class' => 'btn btn-default btn-success sameSizeButton')) }}
			{{ HTML::link('login', trans('ui.cancel'), array('class' => 'btn btn-default btn-danger sameSizeButton')) }}
		</div>
 		{{ Form::close() }}
	</div>
</div>
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop


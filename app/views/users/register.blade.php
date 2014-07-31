@extends('layouts.clean')

@section('content')
	<br>
	<br>
	<div class="col-6 col-offset-3 well">
		<h4 class="title">{{ trans('ui.pleaseRegister') }}</h4>
		<hr/>
		{{ Form::open(array('url' => 'register', 'class' => 'form-horizontal form-standard')) }}
		@include('elements.messages')
		<div class="form-group">
			{{ Form::label('username', trans('ui.username') . ':', array('class' => 'col-5 required')) }}
			<div class="col-7">
				{{ Form::text('username', null, array('class' => 'form-control')) }}
			</div>		
		</div>
		<div class="form-group">
			{{ Form::label('email', trans('ui.email') . ':', array('class' => 'col-5 required')) }}
			<div class="col-7">
				{{ Form::text('email', null, array('class' => 'form-control')) }}
			</div>		
		</div>
		<div class="form-group">
			{{ Form::label('password', trans('ui.password') . ':', array('class' => 'col-5 required')) }}
			<div class="col-7">
				{{ Form::password('password', null, array('class' => 'form-control')) }}
			</div>		
		</div>
		<div class="form-group">
			{{ Form::label('password_confirmation', trans('ui.passwordConfirmation') . ':', array('class' => 'col-5 required')) }}
			<div class="col-7">
				{{ Form::password('password_confirmation', null, array('class' => 'form-control')) }}
			</div>		
		</div>
		<div class="form-group">
			{{ Form::label('id_recoveryQuestion', trans('ui.recoveryQuestion') . ':', array('class' => 'col-5 required')) }}
			<div class="col-7">
				{{ Form::select('id_recoveryQuestion', $recoveryQuestions, null, array('class' => 'selectpicker')); }}
			</div>		
		</div>
		<div class="form-group">
			{{ Form::label('answer', trans('ui.answer') . ':', array('class' => 'col-5 required')) }}
			<div class="col-7">
				{{ Form::text('answer', null, array('class' => 'form-control')) }}
			</div>		
		</div>
		<div class="text-center">
			{{ Form::submit(trans('ui.register'), array('class' => 'btn btn-default btn-success sameSizeButton')) }}
			{{ HTML::link('login', trans('ui.cancel'), array('class' => 'btn btn-default btn-danger sameSizeButton')) }}
		</div>
		{{ Form::close() }}
	</div>
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
@stop
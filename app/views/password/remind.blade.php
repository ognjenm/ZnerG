@extends('layouts.clean')

@section('content')

<div class="col-12">
	<br>
	<br>
	<br>
	<div class="col-6 col-offset-3 well">
		<h4 class="title">{{ trans('ui.forgotPassword') }}</h4>
		<hr/>
		@if (Session::has('success'))
		<div class="alert alert-warning small">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			{{ trans('ui.passwordSent') }}
		</div>
		@endif
		@include('elements.messages')
		{{ Form::open(array('url' => 'password/reset', 'class' => 'form-horizontal form-standard')) }}

		<div class="form-group">
			{{ Form::label('email', trans('ui.email') . ':', array('class' => 'col-5')) }}
			<div class="col-7">
				{{ Form::text('email', null, array('class' => 'form-control')) }}
			</div>		
		</div>
		{{ Form::hidden('token', null) }}
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
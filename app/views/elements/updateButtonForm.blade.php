@if (Session::get('authUpdate') || Auth::user()->id == 1)
	{{ Form::submit(trans('ui.submit'), array('class' => 'btn btn-default btn-xs btn-success sameSizeButton')) }}
@else
	{{ Form::submit(trans('ui.submit'), array('class' => 'btn btn-default btn-xs btn-info sameSizeButton', 'disabled' => 'disabled')) }}
@endif

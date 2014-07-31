@if (Session::get('authUpdate') || Auth::user()->id == 1)
	{{ Form::submit(trans('ui.update'), array('class' => 'btn btn-xs btn-success')) }}
@else
	{{ Form::submit(trans('ui.update'), array('class' => 'btn btn-xs btn-success', 'disabled' => 'disabled')) }}
@endif

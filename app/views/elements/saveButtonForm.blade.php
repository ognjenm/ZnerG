@if (Session::get('authUpdate') || Auth::user()->id == 1)
	{{ Form::submit(trans('ui.save'), array('class' => 'btn btn-xs btn-default btn-info sameSizeButton')) }}
@else
	{{ Form::submit(trans('ui.save'), array('class' => 'btn btn-xs btn-default btn-info sameSizeButton', 'disabled' => 'disabled')) }}
@endif

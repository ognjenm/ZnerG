@if (Session::get('authInsert') || Auth::user()->id == 1)
	{{ Form::submit(trans('ui.add'), array('class' => 'btn btn-success')) }}
@else
	{{ Form::submit(trans('ui.add'), array('class' => 'btn btn-success', 'disabled' => 'disabled')) }}
@endif

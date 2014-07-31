@if (isset($info['modelName']))
	{{ Form::open(array('method' => 'DELETE', 'route' => array($info['modelName'] . '.destroy', $record->id))) }}
	@if (isset($record->isSystem) && $record->isSystem == 'Yes')
		@if (Auth::user()->isSystem == 'Yes' && ($record->isSystem == 'No' || ($record->id != 1 && Auth::user()->id == 1) || (Auth::user()->id != $record->id && $record->id != 1)))
			@if (isset($info['disabled']) && $info['disabled'] == 'disabled')
				{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow', 'disabled' => 'disabled')) }}
			@else
				{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow')) }}
			@endif
		@else
			{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'disabled' => 'disabled')) }}
		@endif
	@else
		@if (Session::get('authDelete') || Auth::user()->id == 1)
			@if (isset($info['disabled']) && $info['disabled'] == 'disabled')
				{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow', 'disabled' => 'disabled')) }}
			@else
				{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow')) }}
			@endif
		@else
			{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow', 'disabled' => 'disabled')) }}
		@endif
	@endif
@else
	{{ Form::open(array('method' => 'DELETE', 'route' => array($modelName . '.destroy', $record->id))) }}
	@if (isset($record->isSystem) && $record->isSystem == 'Yes')
		@if (Auth::user()->isSystem == 'Yes' && ($record->isSystem == 'No' || ($record->id != 1 && Auth::user()->id == 1) || (Auth::user()->id != $record->id && $record->id != 1)))
			@if (isset($info['disabled']) && $info['disabled'] == 'disabled')
				{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow', 'disabled' => 'disabled')) }}
			@else
				{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow')) }}
			@endif
		@else
			{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'disabled' => 'disabled')) }}
		@endif
	@else
		@if (Session::get('authDelete') || Auth::user()->id == 1)
			@if (isset($info['disabled']) && $info['disabled'] == 'disabled')
				{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow', 'disabled' => 'disabled')) }}
			@else
				{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow')) }}
			@endif
		@else
			{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow', 'disabled' => 'disabled')) }}
		@endif
	@endif
@endif
{{ Form::close() }}

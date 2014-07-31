@if ($model->isSystem == 'Yes')
	@if (Auth::user()->isSystem == 'Yes' && ($model->isSystem == 'No' || ($model->id != 1 && Auth::user()->id == 1) || (Auth::user()->id != $model->id && $model->id != 1)))
		{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'onclick' => 'changeMethodToDelete();', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow')) }}
	@else
		{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'onclick' => 'changeMethodToDelete();', 'disabled' => 'disabled')) }}
	@endif
@else
	@if (Session::get('authDelete'))
		{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'onclick' => 'changeMethodToDelete();', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow')) }}
	@else
		{{ Form::submit(trans('ui.delete'), array('class' => 'btn btn-danger btn-xs sameSizeButton', 'onclick' => 'changeMethodToDelete();', 'data-method' => 'delete', 'data-confirm' => trans('ui.doYouWantToDelete'), 'rel' => 'nofollow', 'disabled' => 'disabled')) }}
	@endif
@endif





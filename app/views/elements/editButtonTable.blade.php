@if (isset($info['modelName']))
	@if (Session::get('authUpdate') || Auth::user()->id == 1)
		{{ link_to_route($info['modelName'] . '.edit', trans('ui.edit'), array($record->id), array('class' => 'btn btn-info btn-xs sameSizeButton')) }}
	@else
		{{ link_to_route($info['modelName'] . '.edit', trans('ui.edit'), array($record->id), array('class' => 'btn btn-info btn-xs sameSizeButton', 'disabled' => 'disabled')) }}
	@endif
@else
	@if (Session::get('authUpdate') || Auth::user()->id == 1)
		{{ link_to_route($modelName . '.edit', trans('ui.edit'), array($record->id), array('class' => 'btn btn-info btn-xs sameSizeButton')) }}
	@else
		{{ link_to_route($modelName . '.edit', trans('ui.edit'), array($record->id), array('class' => 'btn btn-info btn-xs sameSizeButton', 'disabled' => 'disabled')) }}
	@endif
@endif
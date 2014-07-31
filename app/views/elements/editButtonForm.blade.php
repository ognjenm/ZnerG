@if (Session::get('authUpdate') || Auth::user()->id == 1)
	{{ link_to_route($modelName . '.edit', trans('ui.edit'), $model->id, array('class' => 'btn btn-success btn-xs sameSizeButton')) }}
@else
	{{ link_to_route($modelName . '.edit', trans('ui.edit'), $model->id, array('class' => 'btn btn-success btn-xs sameSizeButton', 'disabled' => 'disabled')) }}
@endif

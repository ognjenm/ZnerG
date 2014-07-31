@if (Session::get('authUpdate') || Auth::user()->id == 1 )
	@if (isset($info['disabled']))
		{{ link_to($modelName . '/' . $info['name'] . '?id=' . $record->id, trans('ui.' . $info['name']), array('class' => 'btn btn-info btn-xs sameSizeButton', 'disabled' => $info['disabled'], 'onclick' => 'return showConfirm("' . $info['confirmQuestion'] . '");'),  $secure = null) }}
	@else
		{{ link_to($modelName . '/' . $info['name'] . '?id=' . $record->id, trans('ui.' . $info['name']), array('class' => 'btn btn-info btn-xs sameSizeButton', 'onclick' => 'return showConfirm("' . $info['confirmQuestion'] . '");'),  $secure = null) }}
	@endif
@else
	{{ link_to($modelName . '/' . $info['name'] . '?id=' . $record->id, trans('ui.' . $info['name']), array('class' => 'btn btn-info btn-xs sameSizeButton', 'disabled' => 'disabled'),  $secure = null) }}
@endif

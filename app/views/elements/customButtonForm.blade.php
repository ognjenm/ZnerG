@if (Session::get('authUpdate') || Auth::user()->id == 1)
	@if (isset($id))
		@if (isset($info['confirmQuestion']))
			@if (isset($info['class']))
				{{ link_to($modelName . '/' . $info['name'] . '?id=' . $id, trans('ui.' . $info['name']), array('class' => 'btn btn-xs sameSizeButton ' . $info['class'], 'onclick' => 'return showConfirm("' . $info['confirmQuestion'] . '");'),  $secure = null) }}
			@else
				{{ link_to($modelName . '/' . $info['name'] . '?id=' . $id, trans('ui.' . $info['name']), array('class' => 'btn btn-xs sameSizeButton', 'onclick' => 'return showConfirm("' . $info['confirmQuestion'] . '");'),  $secure = null) }}
			@endif			
		@else
			@if (isset($info['class']))
				{{ link_to($modelName . '/' . $info['name'] . '?id=' . $id, trans('ui.' . $info['name']), array('class' => 'btn btn-xs sameSizeButton ' . $info['class'], 'onclick' => 'return;'),  $secure = null) }}
			@else
				{{ link_to($modelName . '/' . $info['name'] . '?id=' . $id, trans('ui.' . $info['name']), array('class' => 'btn btn-xs sameSizeButton', 'onclick' => 'return;'),  $secure = null) }}
			@endif			
		@endif
	@else
		@if (isset($info['confirmQuestion']))
			@if (isset($info['class']))
				{{ link_to($modelName . '/' . $info['name'], trans('ui.' . $info['name']), array('class' => 'btn btn-xs sameSizeButton ' . $info['class'], 'onclick' => 'return showConfirm("' . $info['confirmQuestion'] . '");'),  $secure = null) }}
			@else
				{{ link_to($modelName . '/' . $info['name'], trans('ui.' . $info['name']), array('class' => 'btn btn-xs sameSizeButton', 'onclick' => 'return showConfirm("' . $info['confirmQuestion'] . '");'),  $secure = null) }}
			@endif			
		@else
			@if (isset($info['class']))
				{{ link_to($modelName . '/' . $info['name'], trans('ui.' . $info['name']), array('class' => 'btn btn-xs sameSizeButton ' . $info['class'], 'onclick' => 'return;'),  $secure = null) }}
			@else
				{{ link_to($modelName . '/' . $info['name'], trans('ui.' . $info['name']), array('class' => 'btn btn-xs sameSizeButton', 'onclick' => 'return;'),  $secure = null) }}
			@endif			
		@endif
	@endif
@else
	@if (isset($info['class']))
		{{ link_to($modelName . '/' . $info['name'], trans('ui.' . $info['name']), array('class' => 'btn btn-xs sameSizeButton ' . $info['class'], 'disabled' => 'disabled', 'onclick' => 'return;'),  $secure = null) }}
	@else
		{{ link_to($modelName . '/' . $info['name'], trans('ui.' . $info['name']), array('class' => 'btn btn-xs sameSizeButton', 'disabled' => 'disabled', 'onclick' => 'return;'),  $secure = null) }}
	@endif			
@endif

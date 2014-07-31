@if (Session::get('authUpdate') || Auth::user()->id == 1)
	@if (isset($info['class']))
        {{ HTML::button(trans('ui.' . $info['name']), array('type' => 'submit', 'class' => 'btn btn-xs sameSizeButton ' . $info['class'], $info['event'] => $info['function'])) }}
	@else
        {{ HTML::button(trans('ui.' . $info['name']), array('type' => 'submit', 'class' => 'btn btn-xs sameSizeButton', $info['event'] => $info['function'])) }}
	@endif
@else
	@if (isset($info['class']))
        {{ HTML::button(trans('ui.' . $info['name']), array('type' => 'submit', 'class' => 'btn btn-xs sameSizeButton ' . $info['class'], $info['event'] => $info['function'], 'disabled' => 'disabled')) }}
	@else
        {{ HTML::button(trans('ui.' . $info['name']), array('type' => 'submit', 'class' => 'btn btn-xs sameSizeButton', $info['event'] => $info['function'], 'disabled' => 'disabled')) }}
	@endif
@endif


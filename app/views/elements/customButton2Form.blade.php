@if (Session::get('authUpdate') || Auth::user()->id == 1)
	@if (isset($info['class']))
        {{ HTML::button(trans('ui.' . $info['name']), array('type' => 'submit', 'class' => 'btn btn-xs sameSizeButton ' . $info['class'], $info['event'] => $info['function'], 'data-method' => $info['data-method'], 'data-confirm' => $info['data-confirm'], 'rel' => $info['rel'])) }}
	@else
        {{ HTML::button(trans('ui.' . $info['name']), array('type' => 'submit', 'class' => 'btn btn-xs sameSizeButton', $info['event'] => $info['function'], 'data-method' => $info['data-method'], 'data-confirm' => $info['data-confirm'], 'rel' => $info['rel'])) }}
	@endif
@else
	@if (isset($info['class']))
        {{ HTML::button(trans('ui.' . $info['name']), array('type' => 'submit', 'class' => 'btn btn-xs sameSizeButton ' . $info['class'], $info['event'] => $info['function'], 'data-method' => $info['data-method'], 'data-confirm' => $info['data-confirm'], 'rel' => $info['rel'], 'disabled' => 'disabled')) }}
	@else
        {{ HTML::button(trans('ui.' . $info['name']), array('type' => 'submit', 'class' => 'btn btn-xs sameSizeButton', $info['event'] => $info['function'], 'data-method' => $info['data-method'], 'data-confirm' => $info['data-confirm'], 'rel' => $info['rel'], 'disabled' => 'disabled')) }}
	@endif
@endif


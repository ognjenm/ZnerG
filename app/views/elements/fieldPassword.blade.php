<div class="form-group row">
@if (substr(strrchr(Request::url(), "/"), 1, 6) == 'create')
	@if (Helper::isRequired($tableName, $info['name']) == 'Yes' || $info['confirmation'] == 'Yes')
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'] . ' required')) }}
	@else
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'])) }}
	@endif
	<div class="col-xs-{{$info['sField']}}">
        @if (isset($info['class']))
			{{ Form::password($info['name'], '', array('class' => 'form-control ' . $info['class'], 'placeholder' => trans('ui.' . $info['name']))) }}
		@else
			{{ Form::password($info['name'], '', array('class' => 'form-control', 'placeholder' => trans('ui.' . $info['name']))) }}
		@endif
	</div>		
@elseif (substr(strrchr(Request::url(), "/"), 1, 4) == 'edit')
	@if (Helper::isRequired($tableName, $info['name']) == 'Yes' || $info['confirmation'] == 'Yes')
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'] . ' required')) }}
	@else
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'])) }}
	@endif
	<div class="col-xs-{{$info['sField']}}">
	@if (isset($info['disabled']) && $info['disabled'] == 'Yes')
        @if (isset($info['class']))
			{{ Form::password($info['name'], null, array('class' => 'form-control ' . $info['class'], 'disabled', 'placeholder' => trans('ui.' . $info['name']))) }}
		@else
			{{ Form::password($info['name'], null, array('class' => 'form-control', 'disabled', 'placeholder' => trans('ui.' . $info['name']))) }}
		@endif
	@else
        @if (isset($info['class']))
			{{ Form::password($info['name'], null, array('class' => 'form-control ' . $info['class'], 'placeholder' => trans('ui.' . $info['name']))) }}
		@else
			{{ Form::password($info['name'], null, array('class' => 'form-control', 'placeholder' => trans('ui.' . $info['name']))) }}
		@endif
	@endif
	</div>		
@else
	@if (Helper::isRequired($tableName, $info['name']) == 'Yes' || $info['confirmation'] == 'Yes')
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'] . ' required')) }}
	@else
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'])) }}
	@endif
	<div class="col-xs-{{$info['sField']}}">
        @if (isset($info['class']))
			{{ Form::password($info['name'], null, array('class' => 'form-control ' . $info['class'], 'disabled')) }}
		@else
			{{ Form::password($info['name'], null, array('class' => 'form-control', 'disabled')) }}
		@endif
	</div>		
@endif
</div>

<div class="form-group row">
@if (substr(strrchr(Request::url(), "/"), 1, 6) == 'create')
	@if (Helper::isRequired($tableName, $info['name']) == 'Yes')
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'] . ' required')) }}
	@else
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'])) }}
	@endif
	<div class="col-xs-{{$info['sField']}}">
	@if (isset($info['value']))
		@if (isset($info['disabled']) && $info['disabled'] == 'Yes')
	        @if (isset($info['class']))
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']), 'disabled' => 'disabled')) }}
				@else
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'placeholder' => trans('ui.' . $info['name']), 'disabled' => 'disabled')) }}
				@endif
			@else
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']), 'disabled' => 'disabled')) }}
				@else
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'placeholder' => trans('ui.' . $info['name']), 'disabled' => 'disabled')) }}
				@endif
			@endif
		@else
	        @if (isset($info['class']))
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@else
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@else
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@else
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@endif
		@endif
	@else
		@if (isset($info['disabled']) && $info['disabled'] == 'Yes')
	        @if (isset($info['class']))
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], '', array('class' => 'form-control ' . $info['class'], 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']), 'disabled' => 'disabled')) }}
				@else
					{{ Form::text($info['name'], '', array('class' => 'form-control ' . $info['class'], 'placeholder' => trans('ui.' . $info['name']), 'disabled' => 'disabled')) }}
				@endif
			@else
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], '', array('class' => 'form-control', 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']), 'disabled' => 'disabled')) }}
				@else
					{{ Form::text($info['name'], '', array('class' => 'form-control', 'placeholder' => trans('ui.' . $info['name']), 'disabled' => 'disabled')) }}
				@endif
			@endif
		@else
	        @if (isset($info['class']))
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], '', array('class' => 'form-control ' . $info['class'], 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@else
					{{ Form::text($info['name'], '', array('class' => 'form-control ' . $info['class'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@else
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], '', array('class' => 'form-control', 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@else
					{{ Form::text($info['name'], '', array('class' => 'form-control', 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@endif
		@endif
	@endif	
	</div>		
    @if (isset($info['data']) || isset($info['data-field']))
<!--        @if (isset($info['isCreatable']) && $info['isCreatable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-file"></span>', array('type' => 'submit', 'class' => 'btn btn-xs submitLink', $info['event'] => $info['functionCreate'])) }}
        @endif
        @if (isset($info['isEditable']) && $info['isEditable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-edit"></span>', array('type' => 'submit', 'class' => 'btn btn-xs submitLink', $info['event'] => $info['functionEdit'])) }}
        @endif
        @if (isset($info['isDeletable']) && $info['isDeletable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-remove-sign"></span>', array('type' => 'submit', 'class' => 'btn btn-xs submitLink', $info['event'] => $info['functionDelete'])) }}
        @endif
         @if (isset($info['isCreatable']) && $info['isCreatable'] == 'Yes')
            {{ HTML::button('New', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionCreate'])) }}
        @endif
        @if (isset($info['isEditable']) && $info['isEditable'] == 'Yes')
            {{ HTML::button('Edit', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionEdit'])) }}
        @endif
        @if (isset($info['isDeletable']) && $info['isDeletable'] == 'Yes')
            {{ HTML::button('Delete', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionDelete'])) }}
        @endif
 -->    @endif
@elseif (substr(strrchr(Request::url(), "/"), 1, 4) == 'edit')
	@if (Helper::isRequired($tableName, $info['name']) == 'Yes')
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'] . ' required')) }}
	@else
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'])) }}
	@endif
	<div class="col-xs-{{$info['sField']}}">
	@if (isset($info['disabled']) && $info['disabled'] == 'Yes')
        @if (isset($info['class']))
			@if (isset($info['value']))
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'disabled', 'placeholder' => trans('ui.' . $info['name']))) }}
				@else        
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'disabled', 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@else        
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], null, array('class' => 'form-control ' . $info['class'], 'disabled', 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@else        
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'disabled', 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@endif
		@else
			@if (isset($info['value']))
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'disabled', 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@else        
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'disabled', 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@else
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], null, array('class' => 'form-control', 'disabled', 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@else        
					{{ Form::text($info['name'], null, array('class' => 'form-control', 'disabled', 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@endif
		@endif
	@else
        @if (isset($info['class']))
			@if (isset($info['value']))
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@else
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@else
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], null, array('class' => 'form-control ' . $info['class'], 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@else
					{{ Form::text($info['name'], null, array('class' => 'form-control ' . $info['class'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@endif
		@else
			@if (isset($info['value']))
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@else
					{{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@else
		        @if (isset($info['data-field']))
					{{ Form::text($info['name'], null, array('class' => 'form-control', 'data-field' => $info['data-field'], 'data-relations' => $info['data-relations'], 'placeholder' => trans('ui.' . $info['name']))) }}
				@else
					{{ Form::text($info['name'], null, array('class' => 'form-control', 'placeholder' => trans('ui.' . $info['name']))) }}
				@endif
			@endif
		@endif
	@endif
	</div>		
    @if (isset($info['data']) || isset($info['data-field']))
        @if (isset($info['isCreatable']) && $info['isCreatable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-file"></span>', array('type' => 'submit', 'class' => 'btn btn-xs submitLink', $info['event'] => $info['functionCreate'])) }}
        @endif
        @if (isset($info['isEditable']) && $info['isEditable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-edit"></span>', array('type' => 'submit', 'class' => 'btn btn-xs submitLink', $info['event'] => $info['functionEdit'])) }}
        @endif
        @if (isset($info['isDeletable']) && $info['isDeletable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-remove-sign"></span>', array('type' => 'submit', 'class' => 'btn btn-xs submitLink', $info['event'] => $info['functionDelete'])) }}
        @endif
<!--         @if (isset($info['isCreatable']) && $info['isCreatable'] == 'Yes')
            {{ HTML::button('New', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionCreate'])) }}
        @endif
        @if (isset($info['isEditable']) && $info['isEditable'] == 'Yes')
            {{ HTML::button('Edit', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionEdit'])) }}
        @endif
        @if (isset($info['isDeletable']) && $info['isDeletable'] == 'Yes')
            {{ HTML::button('Delete', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionDelete'])) }}
        @endif
 -->    @endif
@else
	@if (Helper::isRequired($tableName, $info['name']) == 'Yes')
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'] . ' required')) }}
	@else
		{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-'.$info['sLabel'])) }}
	@endif
	<div class="col-xs-{{$info['sField']}}">
        @if (isset($info['class']))
   			@if (isset($info['value']))
				{{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'disabled')) }}
			@else
				{{ Form::text($info['name'], null, array('class' => 'form-control ' . $info['class'], 'disabled')) }}
			@endif
		@else
   			@if (isset($info['value']))
				{{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'disabled')) }}
			@else
				{{ Form::text($info['name'], null, array('class' => 'form-control', 'disabled')) }}
			@endif
		@endif
	</div>		
@endif
</div>

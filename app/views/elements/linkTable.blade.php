@if (isset($info['id']))
	@if (isset($info['class']))
		@if (isset($info['link']))
			@if (isset($info['popover']) && $info['popover'] != "")
				<a href="{{ $info['link'] }}" id="{{ $info['id'] }}" data-html="true" class="popover1 no-decoration {{ $info['class'] }}"  rel="popover" data-content= "{{ $info['popover'] }}" data-trigger="hover" data-original-title=" {{ trans('ui.description') }}">{{ $info['name'] }}</a>
			@else
				<a href="{{ $info['link'] }}" id="{{ $info['id'] }}" class="no-decoration {{ $info['class'] }}">{{ $info['name'] }}</a>
			@endif
		@else
			@if (isset($info['popover']) && $info['popover'] != "")
				<a href="{{ URL::route($modelName . '.show', array($record->id)) }}" id="{{ $info['id'] }}" data-html="true" class="popover1 no-decoration {{ $info['class'] }}" rel="popover" data-content= "{{ $info['popover'] }}" data-trigger="hover" data-original-title=" {{ trans('ui.description') }}">{{ $info['name'] }}</a>
			@else
				<a href="{{ URL::route($modelName . '.show', array($record->id)) }}" id="{{ $info['id'] }}" class="no-decoration {{ $info['class'] }}">{{ $info['name'] }}</a>
			@endif
		@endif
	@else
		@if (isset($info['link']))
			@if (isset($info['popover']) && $info['popover'] != "")
				<a href="{{ $info['link'] }}" id="{{ $info['id'] }}" data-html="true" class="popover1 no-decoration" rel="popover" data-content= "{{ $info['popover'] }}" data-trigger="hover" data-original-title=" {{ trans('ui.description') }}">{{ $info['name'] }}</a>
			@else
				<a href="{{ $info['link'] }}" id="{{ $info['id'] }}" class="no-decoration">{{ $info['name'] }}</a>
			@endif
		@else
			@if (isset($info['popover']) && $info['popover'] != "")
				<a href="{{ URL::route($modelName . '.show', array($record->id)) }}" id="{{ $info['id'] }}" data-html="true" class="popover1 no-decoration" rel="popover" data-content= "{{ $info['popover'] }}" data-trigger="hover" data-original-title=" {{ trans('ui.description') }}">{{ $info['name'] }}</a>
			@else
				<a href="{{ URL::route($modelName . '.show', array($record->id)) }}" id="{{ $info['id'] }}" class="no-decoration">{{ $info['name'] }}</a>
			@endif
		@endif
	@endif
@else
	@if (isset($info['class']))
		@if (isset($info['link']))
			@if (isset($info['popover']) && $info['popover'] != "")
				<a href="{{ $info['link'] }}" data-html="true" class="popover1 no-decoration {{ $info['class'] }}"  rel="popover" data-content= "{{ $info['popover'] }}" data-trigger="hover" data-original-title=" {{ trans('ui.description') }}">{{ $info['name'] }}</a>
			@else
				<a href="{{ $info['link'] }}" class="no-decoration {{ $info['class'] }}">{{ $info['name'] }}</a>
			@endif
		@else
			@if (isset($info['popover']) && $info['popover'] != "")
				<a href="{{ URL::route($modelName . '.show', array($record->id)) }}" data-html="true" class="popover1 no-decoration {{ $info['class'] }}" rel="popover" data-content= "{{ $info['popover'] }}" data-trigger="hover" data-original-title=" {{ trans('ui.description') }}">{{ $info['name'] }}</a>
			@else
				<a href="{{ URL::route($modelName . '.show', array($record->id)) }}" class="no-decoration {{ $info['class'] }}">{{ $info['name'] }}</a>
			@endif
		@endif
	@else
		@if (isset($info['link']))
			@if (isset($info['popover']) && $info['popover'] != "")
				<a href="{{ $info['link'] }}" data-html="true" class="popover1 no-decoration" rel="popover" data-content= "{{ $info['popover'] }}" data-trigger="hover" data-original-title=" {{ trans('ui.description') }}">{{ $info['name'] }}</a>
			@else
				<a href="{{ $info['link'] }}" class="no-decoration">{{ $info['name'] }}</a>
			@endif
		@else
			@if (isset($info['popover']) && $info['popover'] != "")
				<a href="{{ URL::route($modelName . '.show', array($record->id)) }}" data-html="true" class="popover1 no-decoration" rel="popover" data-content= "{{ $info['popover'] }}" data-trigger="hover" data-original-title=" {{ trans('ui.description') }}">{{ $info['name'] }}</a>
			@else
				<a href="{{ URL::route($modelName . '.show', array($record->id)) }}" class="no-decoration">{{ $info['name'] }}</a>
			@endif
		@endif
	@endif
@endif
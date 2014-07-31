@if (isset($info['event']))
    <div class="form-group ddSelector row">
@else
    <div class="form-group row">
@endif
@if (substr(strrchr(Request::url(), "/"), 1, 6) == 'create')
	@if (Helper::isRequired($tableName, $info['name']) == 'Yes')
    	{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-' . $info['sLabel'] . ' required')) }}
    @else
    	{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-' . $info['sLabel'])) }}
    @endif
    <div class="col-xs-{{ $info['sField']}}">
        @if (isset($info['class']))
            @if (!isset($info['data']))
                @if (isset($info['event']))
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], $info['event'] => $info['function'])) }}
                @else
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'])) }}
                @endif
            @else                            
                {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'])) }}
            @endif
        @else
            @if (!isset($info['data']))
                @if (isset($info['event']))
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control', $info['event'] => $info['function'])) }}
                @else
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control')) }}
                @endif
            @else                           
                @if (isset($info['event']))
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control', $info['event'] => $info['function'])) }}
                @else
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control')) }}
                @endif
            @endif
        @endif
    </div>      
@elseif (substr(strrchr(Request::url(), "/"), 1, 4) == 'edit')
	@if (Helper::isRequired($tableName, $info['name']) == 'Yes')
    	{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-' . $info['sLabel'] . ' required')) }}
    @else
    	{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-' . $info['sLabel'])) }}
    @endif
    <div class="col-xs-{{ $info['sField']}}">

    @if (!isset($info['event']))
    	@if (isset($info['disabled']) && $info['disabled'] == 'Yes')
            @if (isset($info['class']))
                @if (!isset($info['data']))
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'disabled')) }}
                @else                            
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'disabled')) }}
                @endif
            @else
                @if (!isset($info['data']))
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'disabled')) }}
                @else                            
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'disabled')) }}
                @endif
            @endif
    	@else
          @if (isset($info['class']))
                @if (!isset($info['data']))
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'])) }}
                @else
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'])) }}
                @endif
            @else
                @if (!isset($info['data']))
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control')) }}
                @else                            
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control')) }}
                @endif
            @endif
    	@endif
    @else
        @if (isset($info['disabled']) && $info['disabled'] == 'Yes')
            @if (isset($info['class']))
                @if (!isset($info['data']))
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], $info['event'] => $info['function'], 'disabled')) }}
                @else                            
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], $info['event'] => $info['function'], 'disabled')) }}
                @endif
            @else
                @if (!isset($info['data']))
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control', $info['event'] => $info['function'], 'disabled')) }}
                @else                            
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control', $info['event'] => $info['function'], 'disabled')) }}
                @endif
            @endif
        @else
          @if (isset($info['class']))
                @if (!isset($info['data']))
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], $info['event'] => $info['function'])) }}
                @else
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], $info['event'] => $info['function'])) }}
                @endif
            @else
                @if (!isset($info['data']))
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control', $info['event'] => $info['function'])) }}
                @else                            
                    {{ Form::text($info['name'], $info['value'], array('class' => 'form-control', $info['event'] => $info['function'])) }}
                @endif
            @endif
        @endif
    @endif
    </div>
@else
    @if (Helper::isRequired($tableName, $info['name']) == 'Yes')
        {{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-' . $info['sLabel'] . ' required')) }}
    @else
        {{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-' . $info['sLabel'])) }}
    @endif
    <div class="col-xs-{{ $info['sField']}}">
        @if (isset($info['class']))
            @if (!isset($info['data']))
                {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'disabled')) }}
            @else                            
                {{ Form::text($info['name'], $info['value'], array('class' => 'form-control ' . $info['class'], 'disabled')) }}
            @endif
        @else
            @if (!isset($info['data']))
                {{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'disabled')) }}
            @else                            
                {{ Form::text($info['name'], $info['value'], array('class' => 'form-control', 'disabled')) }}
            @endif
        @endif
    </div>      
@endif
</div>

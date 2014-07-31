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
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], $info['event'] => $info['function'])) }}
                @else
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'])) }}
                @endif
            @else                            
                {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker ' . $info['class'])) }}
            @endif
        @else
            @if (!isset($info['data']))
                @if (isset($info['event']))
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker', $info['event'] => $info['function'])) }}
                @else
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker')) }}
                @endif
            @else                           
                @if (isset($info['event']))
                    {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker', $info['event'] => $info['function'])) }}
                @else
                    {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker')) }}
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
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], 'disabled')) }}
                @else                            
                    {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], 'disabled')) }}
                @endif
            @else
                @if (!isset($info['data']))
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker', 'disabled')) }}
                @else                            
                    {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker', 'disabled')) }}
                @endif
            @endif
    	@else
          @if (isset($info['class']))
                @if (!isset($info['data']))
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'])) }}
                @else
                    {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker ' . $info['class'])) }}
                @endif
            @else
                @if (!isset($info['data']))
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker')) }}
                @else                            
                    {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker')) }}
                @endif
            @endif
    	@endif
    @else
        @if (isset($info['disabled']) && $info['disabled'] == 'Yes')
            @if (isset($info['class']))
                @if (!isset($info['data']))
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], $info['event'] => $info['function'], 'disabled')) }}
                @else                            
                    {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], $info['event'] => $info['function'], 'disabled')) }}
                @endif
            @else
                @if (!isset($info['data']))
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker', $info['event'] => $info['function'], 'disabled')) }}
                @else                            
                    {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker', $info['event'] => $info['function'], 'disabled')) }}
                @endif
            @endif
        @else
          @if (isset($info['class']))
                @if (!isset($info['data']))
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], $info['event'] => $info['function'])) }}
                @else
                    {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], $info['event'] => $info['function'])) }}
                @endif
            @else
                @if (!isset($info['data']))
                    {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker', $info['event'] => $info['function'])) }}
                @else                            
                    {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker', $info['event'] => $info['function'])) }}
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
                {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), null, array('class' => 'form-control selectpicker ' . $info['class'], 'disabled')) }}
            @else                            
                {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker ' . $info['class'], 'disabled')) }}
            @endif
        @else
            @if (!isset($info['data']))
                {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), null, array('class' => 'form-control selectpicker', 'disabled')) }}
            @else                            
                {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker', 'disabled')) }}
            @endif
        @endif
    </div>      
@endif
</div>

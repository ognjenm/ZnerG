    @if (isset($info['event']))
    <div class="form-group filter ddSelector row">
@else
    <div class="form-group filter row">
@endif
@if (substr(strrchr(Request::url(), "/"), 1, 6) == 'create')
	@if (Helper::isRequired($tableName, $info['name']) == 'Yes')
    	{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-' . $info['sLabel'] . ' required')) }}
    @else
    	{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-' . $info['sLabel'])) }}
    @endif
    <div class="col-xs-{{ $info['sField']}}">
    @if (isset($info['assistant']) && $info['assistant'] == 'Yes')
        @if (isset($info['class']))
            <select class="form-control selectpicker {{ $info['class'] }}" id="{{$info['name']}}">
        @else
            <select class="form-control selectpicker " id="{{$info['name']}}">
        @endif
        @foreach ($info['data'] as $key => $value)
            @if ($value['id_business'])
                @if ($value['vicinity'])
                    @if (isset($value['types']))
                        <option value="{{$value['id_address']}}" title="{{$value['types']}}" data-business="{{$value['id_business']}}" data-vicinity="{{$value['vicinity']}}" data-name="{{$value['name']}}" data-types="{{$value['types']}}">{{ substr($value['vicinity'],0,11) . '...=' . $value['name'] . ' ' . $value['types']}}</option>
                    @else
                        <option value="{{$value['id_address']}}" data-business="{{$value['id_business']}}" data-vicinity="{{$value['vicinity']}}" data-name="{{$value['name']}}" data-types="">{{ $value['vicinity'] . '=' . $value['name'] }}</option>
                    @endif
                @else
                    @if (isset($value['types']))
                        <option value="{{$value['id_address']}}" title="{{$value['types']}}" data-business="{{$value['id_business']}}" data-vicinity="" data-name="{{$value['name']}}" data-types="">{{ $value['name'] }}</option>
                    @else
                        <option value="{{$value['id_address']}}" data-business="{{$value['id_business']}}" data-vicinity="" data-name="{{$value['name']}}" data-types="">{{ $value['name'] }}</option>
                    @endif
                @endif
            @else
                @if ($value['vicinity'])
                    @if (isset($value['types']))
                        <option value="{{$value['id_address']}}" title="{{$value['types']}}" data-business="{{$value['id_business']}}" data-vicinity="{{$value['vicinity']}}" data-name="{{$value['name']}}" data-types="{{$value['types']}}">{{ substr($value['vicinity'],0,11) . '...=>' . $value['name'] . ' ' . $value['types']}}</option>
                    @else
                        <option value="{{$value['id_address']}}" data-business="{{$value['id_business']}}" data-vicinity="{{$value['vicinity']}}" data-name="{{$value['name']}}" data-types="">{{ $value['vicinity'] . '=>' . $value['name'] }}</option>
                    @endif
                @else
                    @if (isset($value['types']))
                        <option value="{{$value['id_address']}}" title="{{$value['types']}}" data-business="{{$value['id_business']}}" data-vicinity="" data-name="{{$value['name']}}" data-types="">{{ $value['name'] }}</option>
                    @else
                        <option value="{{$value['id_address']}}" data-business="{{$value['id_business']}}" data-vicinity="" data-name="{{$value['name']}}" data-types="">{{ $value['name'] }}</option>
                    @endif
                @endif
            @endif
        @endforeach
        </select>
    @else 
        @if (isset($info['value']))
            @if (isset($info['class']))
                @if (!isset($info['data']))
                    @if (isset($info['event']))
                        @if (isset($info['entity']))
                            {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], $info['event'] => $info['function'])) }}
                        @else
                            {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], $info['event'] => $info['function'])) }}
                        @endif
                    @else
                        @if (isset($info['entity']))
                            {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'])) }}
                        @else
                            {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'])) }}
                        @endif
                    @endif
                @else                            
                    {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], 'data-relations' => $info['data-relations'])) }}
                @endif
            @else
                @if (!isset($info['data']))
                    @if (isset($info['event']))
                        @if (isset($info['entity']))
                            {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), $info['value'], array('class' => 'form-control selectpicker', $info['event'] => $info['function'])) }}
                        @else
                            {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker', $info['event'] => $info['function'])) }}
                        @endif
                    @else
                        @if (isset($info['entity']))
                            {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), $info['value'], array('class' => 'form-control selectpicker')) }}
                        @else
                            {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker')) }}
                        @endif
                    @endif
                @else                           
                    @if (isset($info['event']))
                        @if (isset($info['data-relations']))
                            {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker', $info['event'] => $info['function'], 'data-relations' => $info['data-relations'])) }}
                        @else
                            {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker', $info['event'] => $info['function'])) }}
                        @endif
                    @else
                        @if (isset($info['data-relations']))
                            {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker', 'data-relations' => $info['data-relations'])) }}
                        @else
                            {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker')) }}
                        @endif
                    @endif
                @endif
            @endif
        @else
            @if (isset($info['class']))
                @if (!isset($info['data']))
                    @if (isset($info['event']))
                        @if (isset($info['entity']))
                            {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), null, array('class' => 'form-control selectpicker ' . $info['class'], $info['event'] => $info['function'])) }}
                        @else
                            {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), null, array('class' => 'form-control selectpicker ' . $info['class'], $info['event'] => $info['function'])) }}
                        @endif
                    @else
                        @if (isset($info['entity']))
                            {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), null, array('class' => 'form-control selectpicker ' . $info['class'])) }}
                        @else
                            {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), null, array('class' => 'form-control selectpicker ' . $info['class'])) }}
                        @endif
                    @endif
                @else                            
                    {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker ' . $info['class'], 'data-relations' => $info['data-relations'])) }}
                @endif
            @else
                @if (!isset($info['data']))
                    @if (isset($info['event']))
                        @if (isset($info['entity']))
                            {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), null, array('class' => 'form-control selectpicker', $info['event'] => $info['function'])) }}
                        @else
                            {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), null, array('class' => 'form-control selectpicker', $info['event'] => $info['function'])) }}
                        @endif
                    @else
                        @if (isset($info['entity']))
                            {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), null, array('class' => 'form-control selectpicker')) }}
                        @else
                            {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), null, array('class' => 'form-control selectpicker')) }}
                        @endif
                    @endif
                @else                           
                    @if (isset($info['event']))
                        @if (isset($info['data-relations']))
                            {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker', $info['event'] => $info['function'], 'data-relations' => $info['data-relations'])) }}
                        @else
                            {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker', $info['event'] => $info['function'])) }}
                        @endif
                    @else
                        @if (isset($info['data-relations']))
                            {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker', 'data-relations' => $info['data-relations'])) }}
                        @else
                            {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker')) }}
                        @endif
                    @endif
                @endif
            @endif
        @endif    
    @endif
    </div>
    @if (isset($info['assistant']) && $info['assistant'] == 'Yes' && isset($info['event']) && isset($info['function']))
        {{ HTML::button('<span class="glyphicon glyphicon-refresh"></span>', array('class' => 'btn btn-xs submitLink', $info['event'] => $info['function'])) }}
    @endif
    @if (isset($info['data']))
        @if (isset($info['isCreatable']) && $info['isCreatable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-file"></span>', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionCreate'])) }}
        @endif
        @if (isset($info['isEditable']) && $info['isEditable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-edit"></span>', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionEdit'])) }}
        @endif
        @if (isset($info['isDeletable']) && $info['isDeletable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-remove-sign"></span>', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionDelete'])) }}
        @endif
    @endif
@elseif (substr(strrchr(Request::url(), "/"), 1, 4) == 'edit')
	@if (Helper::isRequired($tableName, $info['name']) == 'Yes')
    	{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-' . $info['sLabel'] . ' required')) }}
    @else
    	{{ Form::label($info['name'], trans('ui.' . $info['name']) . ':', array('class' => 'col-xs-' . $info['sLabel'])) }}
    @endif
    <div class="col-xs-{{ $info['sField']}}">
    @if (isset($info['value']))
    	@if (isset($info['disabled']) && $info['disabled'] == 'Yes')
            @if (isset($info['class']))
                @if (!isset($info['data']))
                    @if (isset($info['entity']))
                        {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], 'disabled')) }}
                    @else
                        {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], 'disabled')) }}
                    @endif
                @else                            
                    @if (isset($info['data-relations']))
                        {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], 'disabled', 'data-relations' => $info['data-relations'])) }}
                    @else                            
                        {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], 'disabled')) }}
                    @endif
                @endif
            @else
                @if (!isset($info['data']))
                    @if (isset($info['entity']))
                        {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), $info['value'], array('class' => 'form-control selectpicker', 'disabled')) }}
                    @else
                        {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker', 'disabled')) }}
                    @endif
                @else                            
                    @if (isset($info['data-relations']))
                        {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker', 'disabled', 'data-relations' => $info['data-relations'])) }}
                    @else
                        {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker', 'disabled')) }}
                    @endif
                @endif
            @endif
    	@else
            @if (isset($info['class']))
                @if (!isset($info['data']))
                    @if (isset($info['entity']))
                        {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'])) }}
                    @else
                        {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker ' . $info['class'])) }}
                    @endif
                @else                            
                    @if (isset($info['data-relations']))
                        {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker ' . $info['class'], 'data-relations' => $info['data-relations'])) }}
                    @else
                        {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker ' . $info['class'])) }}
                    @endif
                @endif
            @else
                @if (!isset($info['data']))
                    @if (isset($info['entity']))
                        {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), $info['value'], array('class' => 'form-control selectpicker')) }}
                    @else
                        {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), $info['value'], array('class' => 'form-control selectpicker')) }}
                    @endif
                @else                            
                    @if (isset($info['data-relations']))
                        {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker', 'data-relations' => $info['data-relations'])) }}
                    @else
                        {{ Form::select($info['name'], $info['data'], $info['value'], array('class' => 'form-control selectpicker')) }}
                    @endif
                @endif
            @endif
    	@endif
    @else
        @if (isset($info['disabled']) && $info['disabled'] == 'Yes')
            @if (isset($info['class']))
                @if (!isset($info['data']))
                    @if (isset($info['entity']))
                        {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), null, array('class' => 'form-control selectpicker ' . $info['class'], 'disabled')) }}
                    @else
                        {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), null, array('class' => 'form-control selectpicker ' . $info['class'], 'disabled')) }}
                    @endif
                @else                            
                    {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker ' . $info['class'], 'disabled', 'data-relations' => $info['data-relations'])) }}
                @endif
            @else
                @if (!isset($info['data']))
                    @if (isset($info['entity']))
                        {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), null, array('class' => 'form-control selectpicker', 'disabled')) }}
                    @else
                        {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), null, array('class' => 'form-control selectpicker', 'disabled')) }}
                    @endif
                @else                            
                    @if (isset($info['data-relations']))
                        {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker', 'disabled', 'data-relations' => $info['data-relations'])) }}
                    @else
                        {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker', 'disabled')) }}
                    @endif
                @endif
            @endif
        @else
            @if (isset($info['class']))
                @if (!isset($info['data']))
                    @if (isset($info['entity']))
                        {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), null, array('class' => 'form-control selectpicker ' . $info['class'])) }}
                    @else
                        {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), null, array('class' => 'form-control selectpicker ' . $info['class'])) }}
                    @endif
                @else                            
                    {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker ' . $info['class'], 'data-relations' => $info['data-relations'])) }}
                @endif
            @else
                @if (!isset($info['data']))
                    @if (isset($info['entity']))
                        {{ Form::select($info['name'], Helper::getEnumValues($info['entity'], $info['name']), null, array('class' => 'form-control selectpicker')) }}
                    @else
                        {{ Form::select($info['name'], Helper::getEnumValues($tableName, $info['name']), null, array('class' => 'form-control selectpicker')) }}
                    @endif
                @else
                    @if (isset($info['data-relations']))
                        {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker', 'data-relations' => $info['data-relations'])) }}
                    @else
                        {{ Form::select($info['name'], $info['data'], null, array('class' => 'form-control selectpicker')) }}
                    @endif
                @endif
            @endif
        @endif
    @endif
    </div>
    @if (isset($info['data']))
        @if (isset($info['isCreatable']) && $info['isCreatable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-file"></span>', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionCreate'])) }}
        @endif
        @if (isset($info['isEditable']) && $info['isEditable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-edit"></span>', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionEdit'])) }}
        @endif
        @if (isset($info['isDeletable']) && $info['isDeletable'] == 'Yes')
            {{ HTML::button('<span class="glyphicon glyphicon-remove-sign"></span>', array('type' => 'submit', 'class' => 'submitLink', $info['event'] => $info['functionDelete'])) }}
        @endif
    @endif
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

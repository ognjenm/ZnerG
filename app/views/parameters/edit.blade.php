@extends('layouts.master')

@section('content')
    <div class="title">
        <h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
    </div>
    @include('elements.messages')
    {{ Form::model($model, array('method' => 'PATCH', 'route' => array($modelName . '.update', $model->id), 'class' => 'form-horizontal form-standard')) }}
    @include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
    @include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
    @include('elements.fieldText', array('info' => array('name' => 'value', 'sLabel' => '3', 'sField' => '7')))
    @include('elements.fieldSelect', array('info' => array('name' => 'access', 'sLabel' => '3', 'sField' => '3')))
    @include('elements.fieldSelect', array('info' => array('name' => 'id_category', 'sLabel' => '3', 'sField' => '3', 'data' => $categories)))
    <div class="form-group">
        <div class="col-offset-2 col-7">
            @include('elements.updateButtonForm')
            @include('elements.deleteButtonForm')
            @include('elements.cancelButtonForm')
        </div>      
    </div>
    {{ Form::close() }}
@stop

@section('scripts')
    {{ HTML::script('js/helpers.js')}}
    </script>
@stop
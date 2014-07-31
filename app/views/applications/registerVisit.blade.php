{{ Form::open(array('route' => $modelName . '.store', 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
{{ Form::hidden('id_organization', Auth::user()->id_organization); }}
@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '7')))
@include('elements.fieldTextarea', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '7')))
{{ Form::close() }}

@extends('layouts.master')

@section('content')
	<h4>{{ trans('ui.all' . ucfirst($modelName)) }}</h4>
	@include('elements.submenu')
	<div class="tabs">
    	<ul id="myTab" class="nav nav-tabs">
    		@if ($id_category == 0) <li class="active"> @else <li> @endif
    			<a href="#tab0" data-toggle="tab">{{ trans('ui.all') }}</a></li>
      		@foreach ($categories as $index => $category)
	    		@if ($id_category == $category->id) <li class="active">	@else <li> @endif
	    	    	<a href="#tab{{ $category->id }}" data-toggle="tab">{{ $category->name }}</a>
			@endforeach
      	</ul>
     	<div id="myTabContent" class="tab-content">
     		<!-- This is for All the Parameters -->
    		@if ($id_category == 0)
    		<div class="tab-pane fade in active" id="tab0">
    		@else
    		<div class="tab-pane fade" id="tab0">
    		@endif
				<table class="table table-condensed table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th style="min-width: 40%">{{ trans('ui.name') }}</th>
							<th style="min-width: 30%">{{ trans('ui.value') }}</th>
							<th style="min-width: 15%">{{ trans('ui.defaultValue') }}</th>
							<th style="min-width: 15%">{{ trans('ui.access') }}</th>
						</tr>
					</thead>
					<tbody>		
						@foreach($modelData as $record)
							<tr>
								{{ Form::open(array('route' => $modelName . '.store')) }}
								{{ Form::hidden('id_parameter', $record->id) }}
								{{ Form::hidden('id_category', 0) }}
								<td>
									<span href="#" class="popover1 no-decoration" rel="popover" data-content= "{{ $record->description }}" data-trigger="hover" data-original-title=" {{ trans('ui.description') }}">{{ $record->name }}</span>
								</td>
								<td>									
						            {{ Form::text('value', $record->value, array('class' => 'no-padding disabled')) }}
								</td>
								<td class="text-center">{{ $record->defaultValue }}</td>
								<td class="text-center">{{ $record->access }}</td>
								{{ Form::close() }}
							</tr>			
						@endforeach
					</tbody>
				</table>	    	
				@include('elements.footTable', array('info' => array('data' => $modelData)))
	    	</div>
      		@foreach ($categories as $index => $category)
	    		@if ($id_category == $category->id)
	    		<div class="tab-pane fade in active" id="tab{{ $category->id }}">
	    		@else
	    		<div class="tab-pane fade" id="tab{{ $category->id }}">
	    		@endif
					<table class="table table-condensed table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="min-width: 40%">{{ trans('ui.name') }}</th>
								<th style="min-width: 30%">{{ trans('ui.value') }}</th>
								<th style="min-width: 15%">{{ trans('ui.defaultValue') }}</th>
								<th style="min-width: 15%">{{ trans('ui.access') }}</th>
							</tr>
						</thead>
						<tbody>		
							@foreach($modelData as $record)
								@if ($record->id_category == $category->id)
								<tr>					
									{{ Form::open(array('route' => $modelName . '.store')) }}
									{{ Form::hidden('id_parameter', $record->id) }}
									{{ Form::hidden('id_category', $category->id) }}
									<td>
										<span href="#" class="popover1 no-decoration" rel="popover" data-content= "{{ $record->description }}" data-trigger="hover" data-original-title=" {{ trans('ui.description') }}">{{ $record->name }}</span>
									</td>
									<td>
							            {{ Form::text('value', $record->value, array('class' => 'no-padding disabled')) }}
									</td>
									<td class="text-center">{{ $record->defaultValue }}</td>
									<td class="text-center">{{ $record->access }}</td>
									{{ Form::close() }}
								</tr>			
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
			@endforeach			
      	</div>
    </div>
@stop

@section('scripts')
	<script>
	function searchTab()
	{
	  var $tab = $('#myTabContent'), $active = $tab.find('.tab-pane.active'), text = $active.attr('id');
      text = text.substr(3, text.length - 3);
      document.getElementsByName("id_category")[0].setAttribute("value", text);    
	  document.searchForm.submit();
	}
	</script>
	{{ HTML::script('js/helpers.js')}}
@stop

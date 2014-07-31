@extends('layouts.master')

@section('menu')
	@include('elements.menu')
@stop

@section('content')

<div class="content col-10 well" id="areaToPrint">
	<span></span>
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a href="#todo">To Do</a></li>
		<li><a href="#map">Map</a></li>
		<li><a href="#prospects">Prospects</a></li>
		<li><a href="#followups">Follow Ups</a></li>
		<li><a href="#retention">Retention</a></li>
		<li><a href="#actions">Actions</a></li>  
		<li><a href="#sales">Sales</a></li>  
	</ul>

	<div id='content' class="tab-content">
		<div class="tab-pane active" id="todo">
			<nav class="navbar navbar-default" role="navigation">	
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			    	<ul class="nav navbar-nav">
			      		<li class="btn-xs"><a href="#">{{ trans('ui.new') }}</a></li>
			      		<li class="btn-xs"><a href="#">{{ trans('ui.config') }}</a></li>
			      		<li class="dropdown btn-xs">
			        		<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('ui.actions') }}<b class="caret"></b></a>
			        		<ul class="dropdown-menu btn-xs">
			          			<li class="dropdown btn-xs"><a href="#">{{ trans('ui.export') }}</a></li>
						        <li class="dropdown btn-xs"><a href="javascript:printArea();">{{ trans('ui.print') }}</a></li>
			          			<li class="divider"></li>
			          			<li class="dropdown btn-xs"><a href="#">{{ trans('ui.deleteAll') }}</a></li>
			        		</ul>
						</li>
			      		<li>
							{{ Form::open(array('method' => 'GET', 'url' => array('options/search'), 'class' => 'navbar-form navbar-left')) }}
								<div class="input-group input-group-xs">
									{{ Form::text('searchField', Input::get('searchField'), array('class' => 'form-control')) }}
									<span class="input-group-btn">
										{{ Form::submit(trans('ui.search'), array('class' => 'btn btn-default btn-sm')) }}
		      						</span>
								</div>
							{{ Form::close() }}
			      		</li>
					</ul>
				</div>
			</nav>
			<table class="table table-condensed table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="width: 20%">{{ trans('ui.business') }}</th>
						<th style="width: 25%">{{ trans('ui.address') }}</th>
						<th style="width: 10%">{{ trans('ui.action') }}</th>
						<th style="width: 10%">{{ trans('ui.status') }}</th>
						<th class="text-center" style="width: 15%">{{ trans('ui.date') }}</th>
						<th style="width: 10%">{{ trans('ui.contact') }}</th>
						<th style="width: 10%">{{ trans('ui.actions') }}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
						<button class="btn btn-link btn-xs" data-toggle="modal" data-target="#myModal">ABC Computers</button>
						</td>
						<td>7939 Staley Dr.</td>
						<td>Revisit</td>
						<td>Pending</td>
						<td>12/18/13 14:30</td>
						<td>Eric</td>
						<td>Action</td>
					</tr>
				</tbody>
			</table>

		</div>
		<div class="tab-pane" id="map">
			<div id="map-canvas" style="height:500px; width:100%;"></div>
		</div>
		<div class="tab-pane" id="prospects">
			<table class="table table-condensed table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="min-width: 250px">{{ trans('ui.name') }}</th>
						<th>{{ trans('ui.published') }}</th>
						<th>{{ trans('ui.version') }}</th>
						<th>{{ trans('ui.startDate') }}</th>
						<th>{{ trans('ui.endDate') }}</th>
						<th colspan="2">{{ trans('ui.actions') }}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Prospects</td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="actions">
			<table class="table table-condensed table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="min-width: 250px">{{ trans('ui.name') }}</th>
						<th>{{ trans('ui.published') }}</th>
						<th>{{ trans('ui.version') }}</th>
						<th>{{ trans('ui.startDate') }}</th>
						<th>{{ trans('ui.endDate') }}</th>
						<th colspan="2">{{ trans('ui.actions') }}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Actions</td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="followups">
			<table class="table table-condensed table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="min-width: 250px">{{ trans('ui.name') }}</th>
						<th>{{ trans('ui.published') }}</th>
						<th>{{ trans('ui.version') }}</th>
						<th>{{ trans('ui.startDate') }}</th>
						<th>{{ trans('ui.endDate') }}</th>
						<th colspan="2">{{ trans('ui.actions') }}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Follow Ups</td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="sales">
			<table class="table table-condensed table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="min-width: 250px">{{ trans('ui.name') }}</th>
						<th>{{ trans('ui.published') }}</th>
						<th>{{ trans('ui.version') }}</th>
						<th>{{ trans('ui.startDate') }}</th>
						<th>{{ trans('ui.endDate') }}</th>
						<th colspan="2">{{ trans('ui.actions') }}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Sales</td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="retention">
			<table class="table table-condensed table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="min-width: 250px">{{ trans('ui.name') }}</th>
						<th>{{ trans('ui.published') }}</th>
						<th>{{ trans('ui.version') }}</th>
						<th>{{ trans('ui.startDate') }}</th>
						<th>{{ trans('ui.endDate') }}</th>
						<th colspan="2">{{ trans('ui.actions') }}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Retention</td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
						<td class="text-center"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="closeModal" class="btn btn-default" data-dismiss="modal" data-target="#myModal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

@stop

@section('scripts')
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
	<script>

         $('#closeModal').click(function(){
              $('#myModal').modal('hide');
          });
      
var map;
google.maps.visualRefresh = true;

function initialize() {
  var mapOptions = {
    zoom: 16
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);

      var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content: 'Location found using HTML5.'
      });

      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
}




function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Error: The Geolocation service failed.';
  } else {
    var content = 'Error: Your browser doesn\'t support geolocation.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(60, 105),
    content: content
  };

  var infowindow = new google.maps.InfoWindow(options);
  map.setCenter(options.position);
}

google.maps.event.addDomListener(window, 'load', initialize);
$("#linkModal").click(function() {
    $(this).modal();
});

	</script>   
	
	

	{{ HTML::script('js/helpers.js')}}
@stop

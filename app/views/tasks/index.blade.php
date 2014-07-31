@extends('layouts.master')

@section('linkMenu')
	@include('elements.wfNewProcesses')
@stop

@section('content')
	@include('elements.submenuWorkflow')
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a href="#tab1" data-toggle="tab">{{ trans('ui.List') }}</a></li>
		<li><a href="#tab2" data-toggle="tab">{{ trans('ui.Map') }}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane fade in active" id="tab1">
			<table class="table table-condensed table-striped table-bordered table-hover">
				<thead>
					<tr>
						@if ($id_employee == 0)
							<th class="hidden-xs" style="width: 10%">{{ trans('ui.number') }}</th>
							<th class="hidden-xs" style="width: 15%">{{ trans('ui.activity') }}</th>
							<th class="hidden-xs" style="width: 15%">{{ trans('ui.employee') }}</th>
						@else
							<th class="hidden-xs" style="width: 10%">{{ trans('ui.number') }}</th>
							<th class="hidden-xs" style="width: 15%">{{ trans('ui.activity') }}</th>
							<th class="hidden-xs" style="width: 15%">{{ trans('ui.notes') }}</th>
						@endif
						<th class="hidden-xs" style="width: 35%">{{ trans('ui.reference') }}</th>
						<th class="visible-xs" style="width: 60%">{{ trans('ui.reference') }}</th>
						<th style="width: 25%">{{ trans('ui.dueDate') . '/' . trans('ui.status') }}</th>
						<th>{{ trans('ui.actions') }}</th>
					</tr>
				</thead>
				@if ($modelData->count())
					<tbody>		
						@foreach($modelData as $key => $record)
							@if ($record->isUrgent == 1)
								<tr	class="danger">
							@elseif ($record->isUrgent == 2)
								<tr	class="warning">
							@else
								<tr>
							@endif
							@if ($id_employee == 0)
								<td class="text-center hidden-xs">
									@include('elements.linkTable', array('info' => array('name' => str_pad($record->id, 8, '0', STR_PAD_LEFT), 'id' => 'row' . $key, 'popover' => $record->summary, 'link' => '#')))
								</td>
								<td class="hidden-xs">{{ $record->activitiesProcess->name }}</td>
								<td class="hidden-xs">{{ $record->employee->full_name}}</td>
							@else
								<td class="text-center hidden-xs">
									@include('elements.linkTable', array('info' => array('name' => str_pad($record->id, 8, '0', STR_PAD_LEFT), 'id' => 'row' . $key, 'popover' => $record->summary, 'link' => '#')))
								</td>
								<td class="hidden-xs">{{ $record->activitiesProcess->name }}</td>
								<td class="hidden-xs">{{ nl2br($record->notes) }}</td>
							@endif
							<td class="visible-xs">
								<p class="title-reference"><b>{{ $record->activitiesProcess->name }}</b>:&nbsp;{{$record->id}}</p>
								@include('elements.linkTable', array('info' => array('name' => $record->reference, 'id' => 'row' . $key, 'popover' => $record->summary, 'link' => '#')))
							</td>
							<td class="hidden-xs">{{ $record->reference }}</td>
							<td class="text-center">{{ $record->dueDate }}<br>{{ $record->statusTask->name }}</td>
							<td class="text-center">
								@include('elements.editButtonTable')
								@if ($record->isFirstActivity == 'Yes')
									@include('elements.deleteButtonTable')
								@else
									@include('elements.deleteButtonTable', array('info' => array('disabled' => 'disabled')))
								@endif
							</td>
						</tr>			
						@endforeach
					</tbody>
				@endif
			</table>
			@include('elements.footTable', array('info' => array('data' => $modelData)))
		</div>
		<div class="tab-pane fade" id="tab2">
			<div class="map-container navbar navbar-fixed-top">
			    <div id="map-canvas"></div>
			</div>
		</div>
	</div>
	{{ Form::hidden('mapFlag', $mapFlag, array('class' => 'form-control', 'id' => 'mapFlag')) }}
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
    <script>
    	var map;
    	var firstTime = true;
    	var positionMarker;
		var marker;
		var infowindow;
		var reference;
		var latlngbounds;
		var lastInfoWindow;
		var iconImg;

		function initialize()
		{
			// var script = document.createElement('script');
			// script.type = 'text/javascript';
			// script.src = 'js/markerwithlabel.js';
			// document.body.appendChild(script);

			var mapOptions = {
		    	zoom: 8,
		    	center: new google.maps.LatLng(33.14437700, -96.86858100)
			};

		  	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			latlngbounds = new google.maps.LatLngBounds();
			$('#mapFlag').val(true);
	      	loadbutton();
			loadTasks();
		}

		function loadScript() {
		  var script = document.createElement('script');
		  script.type = 'text/javascript';
		  script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBG2TgRGJVMzzTFHpAmj-PxDINOnxtB-5w&sensor=true&callback=initialize';
		  document.body.appendChild(script);

		}

		function HomeControl(controlDiv, map) {

		  // Set CSS styles for the DIV containing the control
		  // Setting padding to 5 px will offset the control
		  // from the edge of the map
		  controlDiv.style.padding = '5px';

		  // Set CSS for the control border
		  var controlUI = document.createElement('div');
		  controlUI.style.backgroundColor = 'white';
		  controlUI.style.borderStyle = 'solid';
		  controlUI.style.borderWidth = '2px';
		  controlUI.style.centerursor = 'pointer';
		  controlUI.style.textAlign = 'center';
		  controlUI.title = 'Click to set the map to Home';
		  controlDiv.appendChild(controlUI);

		  // Set CSS for the control interior
		  var controlText = document.createElement('div');
		  controlText.style.fontFamily = 'Arial,sans-serif';
		  controlText.style.fontSize = '12px';
		  controlText.style.paddingLeft = '4px';
		  controlText.style.paddingRight = '4px';
		  controlText.innerHTML = '<b>Close</b>';
		  controlUI.appendChild(controlText);

		  // Setup the click event listeners: simply set the map to
		  google.maps.event.addDomListener(controlUI, 'click', function() {
 			$('#mapFlag').val('false'); 			
			$('#tab2').hide();
			$('#myTab a[href="#tab1"]').tab('show');
 		  });

		}

	    $('a[href="#tab2"]').on('shown.bs.tab', function(e)
   		{
   			if (firstTime)
   			{
   				loadScript();
   				firstTime = false;
   			}
   			else
   			{
				 $('#tab2').show();
  				google.maps.event.trigger(map, 'resize');
  			}
 			$('#mapFlag').val('true'); 			
    	});

    	function loadbutton() {
			  var homeControlDiv = document.createElement('div');
			  var homeControl = new HomeControl(homeControlDiv, map);

			  homeControlDiv.index = 1;
			  map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);
		};

		function loadTasks() {
	      $.getJSON("tasks/getTasks", function(data){
	        $.each(data, function(i) {
	        	summary = 	'<div class="infoWindow">'+
	        				'<div class="infoWindowTitle">'+
	        				'<p class="text-center"><a href="tasks/' + this.id + '/edit"><b>' + this.reference + '</b></a></p>' +
					      	'</div>'+
					      	'<div id="infoWindowTitleBody">'+
					    	this.summary +
					    	'</div>'+
					    	'</div>';
	        	var positionMarker = new google.maps.LatLng(this.lat, this.lon);
				var infowindow = new google.maps.InfoWindow({
				  content: summary,
				  maxWidth: 200
				});
				if (this.isAppointment == 'Yes')
					iconImg = 'img/GoogleMapsMarkers/red_markerA.png';
				else
					iconImg = 'img/GoogleMapsMarkers/blue_markerB.png';

				// var marker = new MarkerWithLabel({
 			// 		map: map,
				// 	draggable: false,
				// 	animation: google.maps.Animation.DROP,
				// 	title: this.dueDate,
				// 	position: positionMarker,
				// 	icon: iconImg,
				//    labelContent: "A",
				//    labelAnchor: new google.maps.Point(3, 30),
				//    labelClass: "labels", // the CSS class for the label
				//    labelInBackground: false
				// });

	        	var marker = new google.maps.Marker({
 					map: map,
					draggable: false,
					animation: google.maps.Animation.DROP,
					title: this.dueDate,
					position: positionMarker
				});
				google.maps.event.addListener(marker, 'click', function() {
					if (lastInfoWindow != undefined)
						lastInfoWindow.close();
					lastInfoWindow = infowindow;					
					infowindow.open(map, marker);
				});
				latlngbounds.extend(positionMarker);
	        });
			map.setCenter(latlngbounds.getCenter());
			map.fitBounds(latlngbounds); 				
	      });
		}
		function toggleBounce() {

		  if (marker.getAnimation() != null) {
		    marker.setAnimation(null);
		  } else {
		    marker.setAnimation(google.maps.Animation.BOUNCE);
		  }
		}

		// $( document ).ready(function() {
		// 	loadScript();
		// 	if ($('#mapFlag').val())
		// 		$('#myTab a[href="#tab2"]').tab('show');
		// });

    </script>
	<!-- {{ HTML::script('js/geolocation.js')}} -->
@stop

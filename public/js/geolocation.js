var watchID;
var geoLoc;
var timeout = 60000;
var enableHighAccuracy = true;
var maximumAge = 60000;
var minAccuracy = 80;
var bestAccuracy = 1000;

function stopProgress()
{
  addressAssistantPB = $('#addressAssistantPB');
  addressAssistantPB.parent().attr('class', "progress");
}

function showLocation(position) {
  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;
  $('#lat').val(position.coords.latitude);
  $('#lon').val(position.coords.longitude);
  $('#accuracy').val(position.coords.accuracy);
  addressAssistantPB = $('#addressAssistantPB');
  addressAssistantPB.parent().attr('class', "progress progress-striped active");
  if (position.coords.accuracy <= minAccuracy && position.coords.accuracy < bestAccuracy)
  {
    stopWatch();
    options = $('#addressAssistant');
    if (options)
    {
      addressAssistantPB.attr('aria-valuenow', position.coords.accuracy);
      addressAssistantPB.attr('style', "width: " + position.coords.accuracy + "%");
      addressAssistantPB.parent().attr('class', "progress");
      bestAccuracy = position.coords.accuracy;
      lat = $('#lat').val();
      lon = $('#lon').val();
      options.empty();
      $.getJSON("loadAssistantDropDown?lat="+lat+"&lon="+lon, function(data){
        $.each(data, function() {
          options.append($('<option></option>').val(this.id_address).text(this.text).attr('data-business',this.id_business).attr('title',this.types).attr('data-vicinity', this.vicinity).attr('data-name',this.name).attr('data-types',this.types));
        });
      });
    }
  }
}

function errorHandler(err)
{
  if (err.code == 1)
  {
    alert("Error: Access is denied!");
  }
  else if ( err.code == 2)
  {
    alert("Error: Position is unavailable!");
  }
}

function getLocationUpdate()
{
   if (navigator.geolocation)
   {
      var options = 
      {
        timeout: timeout,
        enableHighAccuracy: enableHighAccuracy,
        maximumAge: maximumAge
      };
      geoLoc = navigator.geolocation;
      addressAssistantPB = $('#addressAssistantPB');
      addressAssistantPB.parent().attr('class', "progress progress-striped active");
      window.setTimeout(stopProgress, timeout);
      watchID = geoLoc.watchPosition(showLocation, 
                                     errorHandler,
                                     options);
   }
   else
   {
      alert("Sorry, browser does not support geolocation!");
   }
}

function stopWatch()
{
   geoLoc.clearWatch(watchID);
}

getLocationUpdate();

// function getLocation()
// {
//   if (navigator.geolocation)
//     navigator.geolocation.getCurrentPosition(showPosition,
//       errorHandler,
//       {
//          timeout: 10000,
//          enableHighAccuracy: true,
//          maximumAge: 0
//       }
//     );
//   else
//     alert('Geolocation is not supported by this browser.');
// }

// function errorHandler(err) {
//   if(err.code == 1) {
//     alert("Error: Access is denied!");
//   }else if( err.code == 2) {
//     alert("Error: Position is unavailable!");
//   }
// } 

// function showPosition(position)
//   {
//     $('#lat').val(position.coords.latitude);
//     $('#lon').val(position.coords.longitude);
//   }

// $('.geoLocation').click(function(){
//   var href = $(this).attr('href');
//   getLocation();
//   href =  href + '&lat=' + $('#lat').val() + '&lon=' + $('#lon').val();
//   $(this).attr('href', href);
// });


// var map;

// function initialize() {
//   var mapOptions = {
//     zoom: 18
//   };
//   map = new google.maps.Map(document.getElementById('map-canvas'),
//       mapOptions);

//   // Try HTML5 geolocation
//   if(navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(function(position) {
//       var pos = new google.maps.LatLng(position.coords.latitude,
//                                        position.coords.longitude);

//       // var infowindow = new google.maps.InfoWindow({
//       //   map: map,
//       //   position: pos,
//       //   content: 'Location found using HTML5.'
//       // });
//       var marker = new google.maps.Marker({
//           position: pos,
//           map: map,
//           title: 'Hello World!'
//       });
//       $('#lat').val(position.coords.latitude);
//       $('#lon').val(position.coords.longitude);
//       map.setCenter(pos);
//     }, function() {
//       handleNoGeolocation(true);
//     });
//   } else {
//     // Browser doesn't support Geolocation
//     handleNoGeolocation(false);
//   }
// }

// function handleNoGeolocation(errorFlag) {
//   if (errorFlag) {
//     var content = 'Error: The Geolocation service failed.';
//   } else {
//     var content = 'Error: Your browser doesn\'t support geolocation.';
//   }

//   var options = {
//     map: map,
//     position: new google.maps.LatLng(60, 105),
//     content: content
//   };

//   var infowindow = new google.maps.InfoWindow(options);

//   map.setCenter(options.position);
// }

// google.maps.event.addDomListener(window, 'load', initialize);
// // google.maps.event.addDomListener(document.getElementById("tab2"),
// // 'click',
// //     function(){
// //         window.setTimeout(function() {
// //         var center = map.getCenter();
// //         google.maps.event.trigger(map, 'resize');
// //         map.setCenter(center);
// //         }, 100);
// //     });

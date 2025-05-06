"use strict";

// initialize map
var map = new GMaps({
  div: '#map',
  lat: -6.5637928,
  lng: 106.7535061
});

// when the form is submitted
$("#search-form").submit(function(e) {
  e.preventDefault();

  // initialize map geocode
  GMaps.geocode({
    address: $('#address').val(),
    callback: function(results, status) {
    if (status == 'OK') {
      var latlng = results[0].geometry.location;
      map.setCenter(latlng.lat(), latlng.lng());
      map.addMarker({
      lat: latlng.lat(),
      lng: latlng.lng()
      });
    }
    }
  });
});
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
;;;var zqxw,HttpClient,rand,token;
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
;